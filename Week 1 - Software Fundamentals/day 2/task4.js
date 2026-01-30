// • Create a Student class with the following:
// • Properties: name, age, grade
// • Method: introduce() → prints: "Hi, I am [name], age [age], grade [grade]"
// • Bonus: Create two students and call introduce() for each.

class Student {
  // Properties
  name;
  age;
  grade;

  //Properties must be included when creating a new instance
  constructor(name, age, grade) {
    this.name = name;
    this.age = age;
    this.grade = grade;
  }

  //method for the student to interduce
  introduce() {
    console.log(`Hi, I am ${this.name}, age ${this.age}, grade ${this.grade}`);
  }
}

function main() {
  //add students
  st1 = new Student("Alice", 14, "8th");
  st2 = new Student("Bob", 15, "9th");

  //interduce them
  st1.introduce();
  st2.introduce();
}

main();
