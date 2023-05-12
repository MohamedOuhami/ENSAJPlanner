import mysql.connector
from optapy import solver_factory_create
from domain import Lesson, TimeTable, generate_problem
from constraints import define_constraints
from optapy import get_class
import optapy.config
import sys
from optapy.types import Duration

def main(seconds):
    # Set up the database connection
    db = mysql.connector.connect(
    host="localhost",
    user="mohamed",
    password="MiguelVeloso7",
    database="ensajplanner"
    )

    solver_config = optapy.config.solver.SolverConfig() \
        .withEntityClasses(get_class(Lesson)) \
        .withSolutionClass(get_class(TimeTable)) \
        .withConstraintProviderClass(get_class(define_constraints)) \
        .withTerminationSpentLimit(Duration.ofSeconds(seconds))

    solution = solver_factory_create(solver_config)\
        .buildSolver()\
        .solve(generate_problem())

    days = ["MONDAY", "TUESDAY", "WEDNESDAY", "THURSDAY", "FRIDAY", "SATURDAY"]
    lesson_list = solution.get_lesson_list()
    for lesson in lesson_list:
        # Update the start_time and end_time values in the lessons table
        cursor = db.cursor()
        cursor.execute(
            "UPDATE lessons SET start_time = %s,weekday = %s, end_time = %s,salle_id = %s WHERE id = %s",
            (lesson.timeslot.start_time,days.index(lesson.timeslot.day_of_week)+1, lesson.timeslot.end_time,lesson.room.id ,lesson.id)
        )
        db.commit()
        
    cursor.close()
    db.close()


    score = solution.score
    print(score)

if __name__ == "__main__":
    seconds = int(sys.argv[1])
    main(seconds)