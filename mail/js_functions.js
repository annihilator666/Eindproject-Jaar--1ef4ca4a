
document.querySelector("input[name='setStartTime']").oninput = function() {adaptTime()};
function adaptTime() {
    let start = document.querySelector("input[name='setStartTime']").value;
    var hours = start.slice(0,2);
    var minutes = start.slice(3,5);
    hours = Number(hours);
    if (hours < 9) {
        hours += 1
        hours = "0" + hours;
    } else if (hours === 0) {
        hours = "01";
    } else {
        hours++;
    }
    document.querySelector("input[name='setEndTime']").value = hours + ":" + minutes;
}
document.querySelector("input[name='setDate']").oninput = function() {adaptDate()};
function adaptDate() {
    var start = document.querySelector('input[name="setDate"]').value;
    document.querySelector('input[name="repeat"]').value = start;

}
var lijst;
fetch('./students.json', {
body: JSON.stringify()
})
.then(response => response.json())
.then(students => {
    lijst = students;
})
.catch((error) => {
console.error('Error:', error);
});
document.querySelector('input[name="email"]').addEventListener('input', () => {
    var option;
    var text;
    var core;
    var val_input = document.querySelector('input[name="email"]').value;
    var options_menu = document.querySelector('#auto_fill');
    var del_whitespace = val_input.replace(/\s/g,'');
    console.log(del_whitespace);
    var split_mail = del_whitespace.split(',');
    var pos = split_mail.length - 1;
    if (split_mail[pos] === 'shuttle3') {
        val_input = '';
        Object.keys(lijst).forEach((key, index) => {
            val_input += lijst[key] + ',';
        });
        document.querySelector('input[name="email"]').value = val_input;
    }
    Object.keys(lijst).forEach((key, index) => {
        if (document.getElementById(key) !== null) {
            option = document.getElementById(key);
            option.parentNode.removeChild(option);
        }
        core = key.replace(/\s/g,'');
        console.log(val_input);
        var re = new RegExp(split_mail[pos], `gi`);
        if (core.match(re) && !document.getElementById(key) && split_mail[pos] !== '') {
            text = document.createTextNode(key);
            option = document.createElement('div');
            option.addEventListener("click", function(){
                setInput(split_mail,pos,lijst,key,val_input);    
            });
            option.id = key;
            option.value = lijst[key];
            option.classList.add('rounded-full', 'input-option');
            option.appendChild(text);
            options_menu.appendChild(option);
        }
    });     
});
function setInput(split_mail,pos,lijst,key,val_input) {
    var i;
    val_input = '';
    split_mail[pos] = lijst[key];
    for (i=0;i<split_mail.length;i++) {
        val_input += split_mail[i] + ',';
    }
    document.querySelector('input[name="email"]').value = val_input;
}
function succes() {
    var field = document.querySelector('.land-mark');
    field.innerHTML = "mail has been send!";
}
document.querySelector('#cal_icon').addEventListener('click', () => {
    if (document.querySelector('input[name="includeReminder"]').value === 'false') {
        document.querySelector('#cal_icon').classList.remove('fa-calendar-check');
        document.querySelector('#cal_icon').classList.add('fa-calendar');
        document.querySelector('input[name="includeReminder"]').value = 'true';
        document.querySelector('#icsCreator').style.display = 'none';
    } else {
        document.querySelector('#cal_icon').classList.remove('fa-calendar');
        document.querySelector('#cal_icon').classList.add('fa-calendar-check');
        document.querySelector('input[name="includeReminder"]').value = 'false';
        document.querySelector('#icsCreator').style.display = 'grid';
    }
});