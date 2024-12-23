#include <error.h>
#include <errno.h>
#include <sys/socket.h>
#include <sys/un.h>
#include <sys/stat.h>
#include <fcntl.h>
#include <unistd.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#include <fastcgi.h>

int fpm_client(char *fpm_socket_file_path, char *result)
{
	int ret, len;

	int unix_stream_socket;
	unix_stream_socket = socket(AF_UNIX, SOCK_STREAM, 0);
	if(unix_stream_socket < 0) {
		error(0, errno, "Can't create unix socket stream");
		return(-1);
	}
	
	struct sockaddr_un addr;
	memset(&addr, 0, sizeof(addr));
	addr.sun_family = AF_UNIX;
	len = strlen(fpm_socket_file_path);
	strncpy(addr.sun_path, fpm_socket_file_path, len);

	ret = connect(unix_stream_socket, (const struct sockaddr *) &addr, sizeof(addr));
	if(ret < 0){
		error(0, errno, "Can't connect to unix socket stream");
		return(-1);
	}
	
	
	FCGI_Header header;
	header.version = FCGI_VERSION_1;
	header.requestIdB1 = 0;
	header.requestIdB0 = 1;
	header.paddingLength = 0;
	
	// FCGI_BEGIN_REQUEST
	
	header.type = FCGI_BEGIN_REQUEST;
	
	FCGI_BeginRequestBody begin_request_body;
	begin_request_body.roleB1 = 0;
	begin_request_body.roleB0 = FCGI_RESPONDER;
	begin_request_body.flags = 0;
	
	len = sizeof(begin_request_body);
	header.contentLengthB1 = 0;
	header.contentLengthB0 = len;
	
	ret = write(unix_stream_socket, &header, sizeof(header));
	if(ret < 0) {
		error(0, errno, "Can't write `begin request header`");
		return(-1);
	}
	
	ret = write(unix_stream_socket, &begin_request_body, len);
	if(ret < 0) {
		error(0, errno, "Can't write `begin request body`");
		return(-1);
	}
	
	// FCGI_PARAMS
	
	header.type = FCGI_PARAMS;
	
	len = 0;
	char *params[] = {
		"SCRIPT_FILENAME", "/var/www/index.php",
		"REQUEST_METHOD", "GET",
		"VAR", "value"
	};
	
	int i, c, nl, vl;
	char buffer[65536];
	c = sizeof(params)/sizeof(params[0]);
	for(i = 0; i < c; i += 2) {
		nl = strlen(params[i]);
		vl = strlen(params[i+1]);
		
		memcpy(buffer+len, &nl, 1);
		len += 1;
		
		memcpy(buffer+len, &vl, 1);
		len += 1;
		
		memcpy(buffer+len, params[i], nl);
		len += nl;
		
		memcpy(buffer+len, params[i+1], vl);
		len += vl;
	}
	
	header.contentLengthB1 = (len >>8) & 0xff;
	header.contentLengthB0 = len & 0xff;
	
	ret = write(unix_stream_socket, &header, sizeof(header));
	if(ret < 0) {
		error(0, errno, "Can't write `params request header`");
		return(-1);
	}
	
	ret = write(unix_stream_socket, buffer, len);
	if(ret < 0) {
		error(0, errno, "Can't write `params request body`");
		return(-1);
	}
	
	header.contentLengthB1 = 0;
	header.contentLengthB0 = 0;
	
	ret = write(unix_stream_socket, &header, sizeof(header));
	if(ret < 0) {
		error(0, errno, "Can't write `empty params request header`");
		return(-1);
	}
	
	// FCGI_STDOUT
	
	ret = read(unix_stream_socket, &header, 8);
	if(ret < 0) {
		error(0, errno, "Can't read stdout response header");
		return(-1);
	}
	
	len = 0;
	len = header.contentLengthB1 << 8;
	len = len | header.contentLengthB0;
	
	memset(buffer, 0, 65536);
	
	ret = read(unix_stream_socket, buffer, len);
	if(ret < 0) {
		error(0, errno, "Can't read stdout response body");
		return(-1);
	}
	
	//write(1, buffer, len);
	
	char *offset;
	offset = strstr(buffer, "\r\n\r\n");
	offset += 4;
	
	//printf("\n%s\n", offset);
	
	len = len-(offset-buffer);
	strncpy(result, offset, len);
	
	ret = close(unix_stream_socket);
	if(ret < 0) {
		error(0, errno, "Can't close unix socket stream");
		return(-1);
	}
	
	return(0);
}

