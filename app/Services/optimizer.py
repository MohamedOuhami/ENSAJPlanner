from constraint import *

# Define the variables and domain
problem = Problem()
lessons = [(1, 9, 101), (1, 10, 101), (2, 9, 101), (2, 10, 101), (3, 9, 101), (3, 10, 101)] # sample lessons
variables = range(len(lessons))
domain = {(i, j, k) for i in range(1, 4) for j in range(9, 13) for k in {101, 102, 103}} # sample domain
for i in variables:
    problem.addVariable(i, domain)

# Define the constraints
def no_conflict(i, j):
    if lessons[i][2] == lessons[j][2]:
        if lessons[i][0] == lessons[j][0]:
            if lessons[i][1] <= lessons[j][1] < lessons[i][1] + 1:
                return False
            if lessons[j][1] <= lessons[i][1] < lessons[j][1] + 1:
                return False
    return True

for i in variables:
    for j in variables:
        if i < j:
            problem.addConstraint(no_conflict, (i, j))

# Define the objective function
def conflicts(*lessons):
    return sum([not no_conflict(i, j) for i in lessons for j in lessons if i < j])

problem.addConstraint(AllDifferentConstraint())
problem.setOptimizationFunction(conflicts)

# Find the solution
solutions = problem.getSolutions()
for solution in solutions:
    print([lessons[i] for i in solution])
