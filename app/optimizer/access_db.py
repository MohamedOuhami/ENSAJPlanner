import mysql.connector

# # class Lesson:
#     def __init__(self, id, subject, teacher, student_group, timeslot=None, room=None):
#         self.id = id
#         self.subject = subject
#         self.teacher = teacher
#         self.student_group = student_group
#         self.timeslot = timeslot
#         self.room = room
try:
    # connect to the database
    db = mysql.connector.connect(
        host="localhost",
        user="mohamed",
        password="MiguelVeloso7",
        database="ensajplanner"
    )

    # fetch the rooms data from the salles table
    cursor = db.cursor()
    cursor.execute(
        "SELECT lessons.id,school_classes.name, users.name , lessons.type "
        "FROM lessons "
        "INNER JOIN users ON lessons.teacher_id = users.id "
        "INNER JOIN school_classes ON lessons.code_matiere = school_classes.id"
        )

    rows = cursor.fetchall()

    print(rows);



except mysql.connector.Error as e:
    print(f"Error connecting to database: {e}")

finally:
    if db.is_connected():
        cursor.close()
        db.close()