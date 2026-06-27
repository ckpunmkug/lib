apt-get install unbound
systemctl stop unbound

  /etc/unbound/unbound.conf
--------------------------------------------------------------------------------
remote-control:
  control-enable: no

server:
	username: unbound
	interface-automatic: no
	interface: 127.0.0.1
	logfile: "/var/log/unbound/unbound.log"
	log-queries: yes
	log-replies: no
	log-tag-queryreply: yes
	verbosity: 0
	
	auto-trust-anchor-file: "/var/lib/unbound/root.key"
	val-permissive-mode: no
--------------------------------------------------------------------------------

mkdir /var/log/unbound
chown unbound:unbound /var/log/unbound

vim /etc/apparmor.d/usr.sbin.unbound

  diff ./usr.sbin.unbound.orig ./usr.sbin.unbound
--------------------------------------------------------------------------------
35a36
>   /var/log/unbound/unbound.log rw,
--------------------------------------------------------------------------------

apparmor_parser -r /etc/apparmor.d/usr.sbin.unbound
systemctl start unbound

  /etc/logrotate.d/unbound
--------------------------------------------------------------------------------
/var/log/unbound/*.log {
	daily
	rotate 7
	missingok
	compress
	delaycompress
	notifempty
	create 640 unbound unbound
	sharedscripts
	postrotate
		systemctl restart unbound >/dev/null 2>&1 || true
	endscript
}
--------------------------------------------------------------------------------

logrotate -v /etc/logrotate.d/unbound
logrotate -f /etc/logrotate.d/unbound

