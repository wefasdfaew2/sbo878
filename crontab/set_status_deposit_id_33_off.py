import MySQLdb
# -*- coding: utf-8 -*-
# Open database connection
db = MySQLdb.connect("27.254.86.130","sc","27qr9rseGY7C59L8","sbobet878",use_unicode=True,charset='utf8')
# prepare a cursor object using cursor() method
cursor = db.cursor()


sql_update = "UPDATE backend_deposit_type \
		      SET deposit_type_status = 'enable' \
		      WHERE deposit_type_id = 33"

try:
	cursor.execute(sql_update)
	cursor.fetchone()
except:
	print "Error: sql_get_deposit_status"
db.close()
