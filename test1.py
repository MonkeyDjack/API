from flask import Flask,request,jsonify
from flask_mysqldb import MySQL
import dicttoxml


app = Flask(__name__)

app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = ''
app.config['MYSQL_DB'] = 'studentgrades'
app.config['MYSQL_CURSORCLASS'] = 'DictCursor'

mysql = MySQL(app)


@app.route('/', methods=['GET','POST'])
def index():
    return "<h1>Students grades details</h1>"
    
@app.route('/DeleteStudent/<string:studentLastName>',methods = ['DELETE'])
def deleteEmployee(last_name):
    cur = mysql.connection.cursor()
    cur.execute("DELETE FROM tbl_students WHERE studentLastName = %s",studentLastName)
    cur.close()
    
@app.route('/UpdateLastName/<string:studentFirstName>,<string:studentLastName>',methods = ['PUT'])
def updateLastName(first_name,last_name):
    cur = mysql.connection.cursor()
    cur.execute("UPDATE tbl_students SET studentLastName = '%s' WHERE studentFirstName = '%s' ",studentFirstName,studentLastName)
    cur.close()
    
@app.route('/AddStudent/<string:studentFirstName>,<string:studentLastName>,<int:dateOfBirth>,<int:Age>,<string:Gender>,<string:Address>,<string:City>,<string:Zip>',methods = ['PUT'])
def addEmployee(fstudentFirstName,studentLastName,dateOfBirth, Age, Gender, Address, City, Zip):
    cur = mysql.connection.cursor()
    cur.execute("INSERT INTO tbl_students (studentFirstName, studentLastName, dateOfBirth, Age, Gender, Address, City, Zip) VALUES ( %s, %s, %s, %i, %s, %s, %s, %s"
,studentFirstName,studentLastName,dateOfBirth, Age, Gender, Address, City, Zip)
    cur.close()

@app.route('/JSONGrades', methods=['GET'])
def JSONGrades():
    cur = mysql.connection.cursor()
    cur.execute("SELECT studentFirstName, studentLastName, Age, Semester, ClassName, Grade FROM tbl_grades  JOIN tbl_students ON tbl_students.StudentID = tbl_grades.studentID JOIN tbl_classes ON tbl_classes.ClassID = tbl_grades.ClassID JOIN tbl_semesters ON tbl_classes.SemesterID = tbl_semesters.SemesterID")
    information = cur.fetchall()
    sentInformation = jsonify(information)
    cur.close()
    return sentInformation
    
@app.route('/XMLGrades', methods=['GET'])
def XMLGrades():
    cur = mysql.connection.cursor()
    cur.execute("SELECT studentFirstName, studentLastName, Age, Semester, ClassName, Grade FROM tbl_grades  JOIN tbl_students ON tbl_students.StudentID = tbl_grades.studentID JOIN tbl_classes ON tbl_classes.ClassID = tbl_grades.ClassID JOIN tbl_semesters ON tbl_classes.SemesterID = tbl_semesters.SemesterID")
    information = cur.fetchall()
    sentInformation = dicttoxml.dicttoxml(information)
    cur.close()
    return sentInformation
    

    


@app.route('/JSONStudentsClass', methods=['GET'])
def JSONStudentsClass():
    cur = mysql.connection.cursor()
    cur.execute("SELECT studentFirstName, ClassName FROM tbl_grades JOIN tbl_students ON tbl_students.StudentID = tbl_grades.StudentID JOIN tbl_classes ON tbl_classes.ClassID = tbl_grades.ClassID")
    information = cur.fetchall()
    sentInformation = jsonify(information)
    cur.close()
    return sentInformation   
    
@app.route('/XMLStudentsClass', methods=['GET'])
def XMLStudentsClass():
    cur = mysql.connection.cursor()
    cur.execute("SELECT studentFirstName, ClassName FROM tbl_grades JOIN tbl_students ON tbl_students.StudentID = tbl_grades.StudentID JOIN tbl_classes ON tbl_classes.ClassID = tbl_grades.ClassID")
    information = cur.fetchall()
    sentInformation = dicttoxml.dicttoxml(information)
    cur.close()
    return sentInformation  
    
    





if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
