import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  passwd="",
  database="project"
)
mycursor = mydb.cursor()
mycursor.execute("SELECT * FROM dataset_baru limit 3")
myresult = mycursor.fetchall()

# without keys
# for myres in myresult:
    # print (myres)

# with keys
for (id_teks, teks, label) in myresult:
    print (id_teks, teks, label)