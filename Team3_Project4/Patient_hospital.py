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

sql = 'select capacity from hospital'
capacities = []
try:
    cursor.execute(sql);
    row = cursor.fetchone()
    while row:
        print("capacity = "+ str(row[0]))
        capacities.append(row[0])
        row=cursor.fetchone()
except mysqldb.IntegrityError:
    print("already in Patient")

sql = 'select patient_id from patientinfo'
pid = []
try:
    cursor.execute(sql);
    row = cursor.fetchone()
    while row:
        print("pid = "+ str(row[0]))
        pid.append(row[0])
        row=cursor.fetchone()
except mysqldb.IntegrityError:
    print("already in Patient")

count = 0
for hid in range(len(capacities)):
    for number in range(capacities[hid]):
        try:
            sql="UPDATE patientinfo SET hospital_id = (%s) where patient_id = (%s) " % (hid+1,pid[count])
            try:
                cursor.execute(sql);
                print("UPDATE data on (%s)"%(pid[count]))
            except mysqldb.IntegrityError:
                print("error!")
            count = count + 1
            sql="UPDATE hospital SET now = (%s) where hospital_id = (%s) " % (number+1,hid+1)
            try:
                cursor.execute(sql);
            except mysqldb.IntegrityError:
                print("error!")
        except:
            print("Finish")
            break;

mydb.commit()
cursor.close()
print("Done")