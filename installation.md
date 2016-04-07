## MySQL Config

#  log_file_size to 25 % of buffer pool size
```
innodb_buffer_pool_size = 100M
innodb_additional_mem_pool_size = 125M
innodb_log_file_size = 10M
innodb_log_buffer_size = 20M
innodb_flush_log_at_trx_commit = 1
innodb_lock_wait_timeout = 50
innodb_file_format = Barracuda
```

## PHP Config

#  File Upload
```
upload_max_filesize=25M
```