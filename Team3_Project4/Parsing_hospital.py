# -*- coding: utf-8 -*-
# import getpass
import pymysql as mysqldb

# userid = input('Username: ')
# userpwd=getpass.getpass(prompt="Password: ")
# dbname='stid_2018110292'

mydb=mysqldb.connect(host='127.0.0.1',
                     user='root',
                     passwd='',
                     db='')
cursor=mydb.cursor()

reading_file = open('Hospital.csv', 'rt', encoding='UTF8')
lines = reading_file.readlines()

for line in lines:
    tok = line.strip().split(',')
    if (tok[0]=='﻿Hospital_id'):
        continue

    hid = tok[0].strip()
    hname = tok[1].strip()
    if(hname!="NULL"):
        hname = hname.replace('\'','\\\'')
        hname ='"{}"'.format(hname)
    province = tok[2].strip()
    if(province!="NULL"):
        province='"{}"'.format(province)
    city = tok[3].strip()
    if(city!="NULL"):
        city='"{}"'.format(city)
    hlatitude = tok[4].strip()
    hlongitude = tok[5].strip()
    capacity = tok[6].strip()
    current = tok[7].strip()

    patient_vals ="%s, %s, %s, %s, %s, %s, %s, %s" % (hid, hname, province, city, hlatitude, hlongitude, capacity, current)
    sql = 'INSERT INTO hospital VALUES (%s)' % patient_vals


    try:
        cursor.execute(sql);
        print("Inserting [%s, %s] to Patient" % (hid, hname))
    except mysqldb.IntegrityError:
        print("%s already in Patient" % hid)

mydb.commit()
cursor.close()
print("Done")