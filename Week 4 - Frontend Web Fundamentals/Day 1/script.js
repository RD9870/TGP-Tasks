// Exercise 1 code
//1,2,4,6,t,
e1Btn = document.getElementById("e1Btn");
userInput = null;
e1Btn.onclick = () => {
  // get user input
  userInput = prompt("Type numbers seperated by commas: 1,2,3");
  //show user the results
  e1Res = document.getElementById("e1Res");
  e1Res.innerHTML = `Your input = ${userInput} \n The Result = ${sumArray(
    userInput
  )}`;
};

//sum numbers in an array
function sumArray(arr) {
  arr = splitUserInput(arr);
  sum = 0;
  arr.map((num) => {
    if (Number(num)) {
      sum += Number(num);
    }
  });
  return sum;
}

// Exercise 2 code
//   Ali,Sara,Omran,Ahmed,Aya,Yasmeen
e2Btn = document.getElementById("e2Btn");
userInput = null;
e2Btn.onclick = () => {
  //get user input
  userInput = prompt("Enter names seperated by commas: Yaser,Farah");
  //put user input in an array and filter out names shorter than 4 letter
  filteredArray = splitUserInput(userInput).filter(checkNameLength);
  //   show user the results
  e2Res = document.getElementById("e2Res");
  e2Res.innerHTML = `Your Input ${userInput} \n Results: ${filteredArray}`;
};

//ignore names shorter than 4 letters
function checkNameLength(name) {
  if (name.length >= 4) {
    return name;
  }
  // return name.length >= 4;
}

// Exercise 3 code
//     hello world hello my     world beautiful day
e3Btn = document.getElementById("e3Btn");
userInput = null;
e3Btn.onclick = () => {
  // get user input
  userInput = prompt("Enter a scentence");
  // ■ Splits the sentence into words
  wordArray = userInput.split(" ");
  // ■ Removes extra spaces
  wordArray = wordArray.filter(rmoveEmptyStrings);
  // ■ Counts how many times each word appears
  wordsCount = countWords(wordArray);
  //display results to the user
  e3Res = document.getElementById("e3Res");
  e3Res.innerHTML = `Your Input ${userInput} \n Results: ${wordsCount}`;
};

// remove empty strings from an array
function rmoveEmptyStrings(item) {
  if (item != "") {
    return item;
  }
}

// count how many times a word is repeated in a string array
function countWords(arr) {
  countObject = arr.reduce((count, word) => {
    count[word] = (count[word] || 0) + 1;
    return count;
  }, {});
  console.log(countObject);
  // ■ Returns an object with the results
  return JSON.stringify(countObject);
}

//helpers
function splitUserInput(arr) {
  sepArray = arr.split(",");
  return sepArray;
}
