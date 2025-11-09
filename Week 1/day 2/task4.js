// • Create a Student class with the following:
// • Properties: name, age, grade
// • Method: introduce() → prints: "Hi, I am [name], age [age], grade [grade]"
// • Bonus: Create two students and call introduce() for each. 

class Student {
    name;
    age;
    grade;

    constructor(name,age,grade){
        this.name = name;
        this.age = age;
        this.grade = grade;}

    introduce(){
        console.log(`Hi, I am ${this.name}, age ${this.age}, grade ${this.grade}`);
        
    }
    }


function main(){
st1 = new Student('Alice', 14, '8th');
st2 = new Student('Bob', 15, '9th');

st1.introduce();
st2.introduce();
}

main();
