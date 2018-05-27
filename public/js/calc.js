function addField(number) {
  var field = document.getElementById('field');
  var fieldNumber = field.innerHTML;
  if(fieldNumber.length < 10) {
    if (fieldNumber == 0 && number !== "." && fieldNumber.indexOf('.') == -1) {
      field.innerHTML = number;
    }else {
      if (number === "." && fieldNumber.indexOf('.') !== -1) {
      number = "";
      }
      field.innerHTML += number;
    }
  }
}
function addOperator(operator) {
  var field = document.getElementById('field');
  var fieldNumber = field.innerHTML;
  var foumulaArea = document.getElementById('foumulaArea');
  var foumula = foumulaArea.innerHTML;
  if(foumula.indexOf('+')== -1 && foumula.indexOf('-')== -1 && foumula.indexOf('*')== -1 && foumula.indexOf('/')== -1) {
	  foumulaArea.innerHTML = fieldNumber + operator;
	  field.innerHTML = 0;
  }
}

function deleteDigit() {
  var field = document.getElementById('field');
  var fieldNumber = field.innerHTML;
  if (fieldNumber !== 0) {
    if(fieldNumber.slice(0,-1) === "") {
      field.innerHTML = 0
    }else {
      field.innerHTML = fieldNumber.slice(0,-1);
    }
  }
}

function setMemory() {
  var field = document.getElementById('field');
  var memoryArea = document.getElementById('memoryArea');
  if(!isNaN(field.innerHTML)) {
    memoryArea.innerHTML = field.innerHTML;
  }
}

function readMemory() {
  var field = document.getElementById('field');
  var memoryArea = document.getElementById('memoryArea');
  if (memoryArea.innerHTML) {
    field.innerHTML = memoryArea.innerHTML;
  }
  memoryArea.innerHTML = "";
}

function clearMemory() {
  var memoryArea = document.getElementById('memoryArea');
  if (memoryArea.innerHTML) {
    memoryArea.innerHTML = "";
  }
}

function addMemory() {
  var field = document.getElementById('field');
  var memoryArea = document.getElementById('memoryArea');
  if (memoryArea.innerHTML) {
    var number = parseInt(field.innerHTML) + parseInt(memoryArea.innerHTML);
    field.innerHTML = number;
    memoryArea.innerHTML = number;
  }else {}
}

function minusMemory() {
  var field = document.getElementById('field');
  var memoryArea = document.getElementById('memoryArea');
  if (memoryArea.innerHTML) {
    var number = parseInt(field.innerHTML) - parseInt(memoryArea.innerHTML);
    field.innerHTML = number;
    memoryArea.innerHTML = number;
  }else {}
}

function clearAll() {
  var field = document.getElementById('field');
  var foumulaArea = document.getElementById('foumulaArea');
  field.innerHTML = 0;
  foumulaArea.innerHTML = 0;
}

function clearField() {
  var field = document.getElementById('field');
  field.innerHTML = 0;
}
