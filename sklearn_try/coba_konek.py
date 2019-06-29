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

for x in myresult:
  print(x)