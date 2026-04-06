const Students = [
{ id:1, name:"David", age:20, marks:78, course:"IT"},
{ id:2, name:"Rahul", age:21, marks:85, course:"CS"},
{ id:3, name:"Gita", age:22, marks:88, course:"AIDS"},
{ id:4, name:"Ananya", age:19, marks:92, course:"AI"},
{ id:5, name:"Vikram", age:22, marks:74, course:"IT"},
{ id:6, name:"Priya", age:20, marks:88, course:"DS"},
{ id:7, name:"Hemanth", age:21, marks:76, course:"AIDS"},
{ id:8, name:"Karan", age:21, marks:69, course:"IT"},
{ id:9, name:"Sneha", age:19, marks:95, course:"AI"},
{ id:10, name:"Rohit", age:20, marks:78, course:"AIDS"},
{ id:11, name:"Arjun", age:20, marks:81, course:"CS"},
{ id:12, name:"Meera", age:22, marks:86, course:"DS"},
{ id:13, name:"Bhavana", age:20, marks:86, course:"AIDS"},
{ id:14, name:"Rohan", age:21, marks:72, course:"IT"},
];

let filteredStudents = [...Students];

function displayStudents(data){

const table = document.getElementById("studentTable");
table.innerHTML="";

data.forEach(student=>{
let row = `
<tr>
<td>${student.id}</td>
<td>${student.name}</td>
<td>${student.age}</td>
<td>${student.marks}</td>
<td>${student.course}</td>
</tr>
`;
table.innerHTML += row;
});

}

function applyFilters(){

const searchValue = document.getElementById("searchInput").value.toLowerCase();
const courseValue = document.getElementById("courseFilter").value;

filteredStudents = Students.filter(student => {

const matchName = student.name.toLowerCase().includes(searchValue);
const matchCourse = courseValue === "All" || student.course === courseValue;

return matchName && matchCourse;

});

displayStudents(filteredStudents);

}

function sortByMarks(){

filteredStudents.sort((a,b)=> b.marks - a.marks);
displayStudents(filteredStudents);

}

document.getElementById("searchInput").addEventListener("keyup", applyFilters);
document.getElementById("courseFilter").addEventListener("change", applyFilters);

displayStudents(Students);