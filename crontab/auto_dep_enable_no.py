import MySQLdb
# -*- coding: utf-8 -*-
# Open database connection
db = MySQLdb.connect("27.254.86.130","sc","27qr9rseGY7C59L8","sbobet878",use_unicode=True,charset='utf8')
# prepare a cursor object using cursor() method
cursor = db.cursor()


sql_update = "UPDATE global_setting \
		SET   `auto_deposit_enable` ='No',`announce_enable`='Yes', \
		`announce_text`='ช่วงเวลา 21.40-05.30 ของทุกวันทางเว็บไซต์จะทำการปิดระบบชำระเงินแบบอัตโนมัติ<br/> แต่ท่านสมาชิกยังคงโอนเงินแบบแจ้ง Call Center ได้อยู่ตามปกติครับ'"

try:
	cursor.execute(sql_update)
	cursor.fetchone()
except:
	print "Error: sql_get_deposit_status"
db.close()
