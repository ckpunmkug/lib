#include "fpm_client.h"

int main()
{
	int ret;
	
	char *fpm_socket_file_path = "/var/run/php/php7.4-fpm.sock\0";
	char str[256];
	memset(str, 0, 256);
	ret = fpm_client(fpm_socket_file_path, str);
	if(ret < 0) {
		return(1);
	}
	printf("Result: %s\n", str);
	
	return(0);
}

