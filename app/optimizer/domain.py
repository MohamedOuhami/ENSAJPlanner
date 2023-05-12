from datetime import time
from optapy import planning_solution, planning_entity_collection_property, \
    problem_fact_collection_property, \
    value_range_provider, planning_score
from optapy import planning_entity, planning_variable
from typing import List
from optapy.score import HardSoftScore
from optapy import problem_fact, planning_id
import mysql.connector


@problem_fact
class Room:
    def __init__(self, id, label, type,capacity):
        self.id = id
        self.label = label
        self.type = type
        self.capacity = capacity

    @planning_id
    def get_id(self):
        return self.id

    def get_label(self):
        return self.label

    def get_type(self):
        return self.type

        

    def __str__(self):
        return f"Room(id={self.id}, label={self.label}, type={self.type})"


@problem_fact
class Timeslot:
    def __init__(self, id, day_of_week, start_time, end_time):
        self.id = id
        self.day_of_week = day_of_week
        self.start_time = start_time
        self.end_time = end_time

    @planning_id
    def get_id(self):
        return self.id

    def __str__(self):
        return (
            f"Timeslot("
            f"id={self.id}, "
                f"day_of_week={self.day_of_week}, "
                f"start_time={self.start_time}, "
                f"end_time={self.end_time})"
        )


@planning_entity
class Lesson:
    def __init__(self, id, subject, section, teacher,semester, student_group=None, timeslot=None, room=None, lesson_type=None):
        self.id = id
        self.subject = subject
        self.teacher = teacher
        self.section = section
        self.semester = semester
        self.student_group = student_group
        self.timeslot = timeslot
        self.room = room
        self.lesson_type = lesson_type


    @planning_id
    def get_id(self):
        return self.id

    @planning_variable(Timeslot, ["timeslotRange"])
    def get_timeslot(self):
        return self.timeslot

    def set_timeslot(self, new_timeslot):
        self.timeslot = new_timeslot

    @planning_variable(Room, ["roomRange"])
    def get_room(self):
        return self.room

    def set_room(self, new_room):
        self.room = new_room

    def __str__(self):
        return (
            f"Lesson("
            f"id={self.id}, "
            f"timeslot={self.timeslot}, "
            f"room={self.room}, "
            f"teacher={self.teacher}, "
            f"subject={self.subject}, "
            f"student_group={self.student_group}"
            f")"
        )


def format_list(a_list):
    return ',\n'.join(map(str, a_list))


@planning_solution
class TimeTable:
    def __init__(self, timeslot_list, room_list, lesson_list, score=None):
        self.timeslot_list = timeslot_list
        self.room_list = room_list
        self.lesson_list = lesson_list
        self.score = score

    @problem_fact_collection_property(Timeslot)
    @value_range_provider("timeslotRange")
    def get_timeslot_list(self):
        return self.timeslot_list

    @problem_fact_collection_property(Room)
    @value_range_provider("roomRange")
    def get_room_list(self):
        return self.room_list

    @planning_entity_collection_property(Lesson)
    def get_lesson_list(self):
        return self.lesson_list

    @planning_score(HardSoftScore)
    def get_score(self):
        return self.score

    def set_score(self, score):
        self.score = score

    def __str__(self):
        return (
            f"TimeTable("
            f"timeslot_list={format_list(self.timeslot_list)},\n"
            f"room_list={format_list(self.room_list)},\n"
            f"lesson_list={format_list(self.lesson_list)},\n"
            f"score={str(self.score.toString()) if self.score is not None else 'None'}"
            f")"
        )


def generate_problem():
    days = ["MONDAY", "TUESDAY", "WEDNESDAY", "THURSDAY", "FRIDAY", "SATURDAY"]
    timeslot_list = []
    for day in days:
        if(day != "SATURDAY"):
            timeslot_list.append(Timeslot(
                len(timeslot_list)+1, day, time(hour=8, minute=00), time(hour=10, minute=00)))
            timeslot_list.append(Timeslot(
                len(timeslot_list)+1, day, time(hour=10, minute=15), time(hour=12, minute=15)))
            timeslot_list.append(Timeslot(
                len(timeslot_list)+1, day, time(hour=13, minute=0), time(hour=15, minute=00)))
            timeslot_list.append(Timeslot(
                len(timeslot_list)+1, day, time(hour=15, minute=15), time(hour=17, minute=15)))
        else:
            timeslot_list.append(Timeslot(
                len(timeslot_list)+1, day, time(hour=8, minute=00), time(hour=10, minute=00)))
            timeslot_list.append(Timeslot(
                len(timeslot_list)+1, day, time(hour=10, minute=15), time(hour=12, minute=15)))


        rooms = []

    def get_rooms(rooms):
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
            cursor.execute("SELECT id, label, type,capacity FROM salles")
            rows = cursor.fetchall()

            # create Room objects for each row and add them to the list
            for row in rows:
                id, label, type,capacity = row
                room = Room(id, label, type,capacity)
                rooms.append(room)

        except mysql.connector.Error as e:
            print(f"Error connecting to database: {e}")

        finally:
            if db.is_connected():
                cursor.close()
                db.close()

    def get_lessons(lessons):
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
                "SELECT lessons.id, school_classes.name, users.name, lessons.type, sections.Intitule,sections.Semester, groups.intitule "
                "FROM lessons "
                "INNER JOIN users ON lessons.teacher_id = users.id "
                "INNER JOIN school_classes ON lessons.code_matiere = school_classes.id "
                "INNER JOIN timetables ON lessons.timetable_id = timetables.id "
                "INNER JOIN sections ON timetables.section_id = sections.id "
                "LEFT JOIN lesson_group ON lessons.id = lesson_group.lesson_id "
                "LEFT JOIN groups ON lesson_group.group_id = groups.id"
                )


            rows = cursor.fetchall()

            for row in rows:
                id, matiere, teacher_name, type, section,semestre, group = row
                if type == "Cours":
                    lesson = Lesson(id=id, subject=matiere,  section=section + "-" + semestre,teacher=teacher_name,semester=semestre,student_group=section + "-" + semestre,lesson_type=type)
                elif type == "TD":
                    lesson = Lesson(id, subject=matiere,section=section + "-" + semestre,teacher=teacher_name,semester=semestre, student_group=group + " - " + semestre,lesson_type=type)
                    
                elif type == "TP":
                    lesson = Lesson(id, subject=matiere,section=section + "-" + semestre,teacher=teacher_name,semester=semestre,student_group=section + "-" + semestre,lesson_type=type)


                lessons.append(lesson)

                

        except mysql.connector.Error as e:
            print(f"Error connecting to database: {e}")

        finally:
            if db.is_connected():
                cursor.close()
                db.close()

    get_rooms(rooms)

    lesson_list = []

    get_lessons(lesson_list)
    lesson = lesson_list[0]
    lesson.set_timeslot(timeslot_list[0])
    lesson.set_room(rooms[0])

    return TimeTable(timeslot_list, rooms, lesson_list)
