from domain import Lesson, Room
from optapy import constraint_provider, get_class
from optapy.constraint import Joiners
from optapy.score import HardSoftScore

# Constraint Factory takes Java Classes, not Python Classes
LessonClass = get_class(Lesson)
RoomClass = get_class(Room)


@constraint_provider
def define_constraints(constraint_factory):
    return [
        # Hard constraints
        cours_conflict(constraint_factory),
        room_conflict(constraint_factory),
        teacher_conflict(constraint_factory),
        student_group_conflict(constraint_factory),
        cours_TD_conflict(constraint_factory),
        cours_TP_conflict(constraint_factory),
        TD_TP_conflict(constraint_factory),
        salle_type_conflict(constraint_factory)

        # Soft constraints are only implemented in the optapy-quickstarts code
    ]


def salle_type_conflict(constraint_factory):
    # Cours lessons can only occur in salles of type "Cours"
    return constraint_factory \
        .forEach(LessonClass) \
        .filter(lambda lesson: lesson.lesson_type != lesson.room.type) \
        .penalize("Salle type conflict for Cours lessons", HardSoftScore.ONE_HARD)


def cours_TD_conflict(constraint_factory):
    # Two courses from the same section cannot occur at the same time.
    return constraint_factory \
        .forEach(LessonClass) \
        .join(LessonClass,
              [
                  Joiners.equal(lambda lesson: lesson.timeslot),
                  Joiners.lessThan(lambda lesson: lesson.id)
              ]) \
        .filter(lambda lesson1, lesson2:
                (
                    (lesson1.lesson_type == "Cours" and lesson2.lesson_type == "TD") or (
                        lesson2.lesson_type == "Cours" and lesson1.lesson_type == "TD")
                ) and
                lesson1.section == lesson2.section) \
        .penalize("TD Cours conflict", HardSoftScore.ONE_HARD)


def cours_TP_conflict(constraint_factory):
    # Two courses from the same section cannot occur at the same time.
    return constraint_factory \
        .forEach(LessonClass) \
        .join(LessonClass,
              [
                  Joiners.equal(lambda lesson: lesson.timeslot),
                  Joiners.lessThan(lambda lesson: lesson.id)
              ]) \
        .filter(lambda lesson1, lesson2:
                (
                    (lesson1.lesson_type == "Cours" and lesson2.lesson_type == "TP") or (
                        lesson2.lesson_type == "Cours" and lesson1.lesson_type == "TP")
                ) and
                lesson1.section == lesson2.section) \
        .penalize("TP Cour conflict", HardSoftScore.ONE_HARD)


def TD_TP_conflict(constraint_factory):
    # Two courses from the same section cannot occur at the same time.
    return constraint_factory \
        .forEach(LessonClass) \
        .join(LessonClass,
              [
                  Joiners.equal(lambda lesson: lesson.timeslot),
                  Joiners.lessThan(lambda lesson: lesson.id)
              ]) \
        .filter(lambda lesson1, lesson2:
                (
                    (lesson1.lesson_type == "TP" and lesson2.lesson_type == "TD") or (
                        lesson2.lesson_type == "TP" and lesson1.lesson_type == "TD")
                ) and
                lesson1.section == lesson2.section ) \
        .penalize("TP TD conflict", HardSoftScore.ONE_HARD)


def cours_conflict(constraint_factory):
    # Two courses from the same section cannot occur at the same time.
    return constraint_factory \
        .forEach(LessonClass) \
        .join(LessonClass,
              [
                  Joiners.equal(lambda lesson: lesson.timeslot),
                  Joiners.lessThan(lambda lesson: lesson.id)
              ]) \
        .filter(lambda lesson1, lesson2:
                lesson1.lesson_type == "Cours" and
                lesson2.lesson_type == "Cours" and
                lesson1.section == lesson2.section) \
        .penalize("Cours conflict", HardSoftScore.ONE_HARD)


def room_conflict(constraint_factory):
    # A room can accommodate at most one lesson at the same time.
    return constraint_factory \
        .forEach(LessonClass) \
        .join(LessonClass,
              [
                  # ... in the same timeslot ...
                  Joiners.equal(lambda lesson: lesson.timeslot),
                  # ... in the same room ...
                  Joiners.equal(lambda lesson: lesson.room),
                  # ... and the pair is unique (different id, no reverse pairs) ...
                  Joiners.lessThan(lambda lesson: lesson.id)
              ]) \
        .penalize("Room conflict", HardSoftScore.ONE_HARD)


def teacher_conflict(constraint_factory):
    # A teacher can teach at most one lesson at the same time.
    return constraint_factory \
        .forEach(LessonClass)\
        .join(LessonClass,
              [
                  Joiners.equal(lambda lesson: lesson.timeslot),
                  Joiners.equal(lambda lesson: lesson.teacher),
                  Joiners.lessThan(lambda lesson: lesson.id)
              ]) \
        .penalize("Teacher conflict", HardSoftScore.ONE_HARD)


def student_group_conflict(constraint_factory):
    # A student can attend at most one lesson at the same time.
    return constraint_factory \
        .forEach(LessonClass) \
        .join(LessonClass,
              [
                  Joiners.equal(lambda lesson: lesson.timeslot),
                  Joiners.equal(lambda lesson: lesson.student_group),
                  Joiners.lessThan(lambda lesson: lesson.id)
              ]) \
        .penalize("Student group conflict", HardSoftScore.ONE_HARD)
