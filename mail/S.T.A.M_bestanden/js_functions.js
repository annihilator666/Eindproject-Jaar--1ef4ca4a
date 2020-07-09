document.querySelector('input[name="includeReminder"]').addEventListener('click', function(){
    if(document.querySelector('input[name="includeReminder"]').checked ===  false) {
        document.querySelector('#icsCreator').style.display = 'none';
    }
    else {
        document.querySelector('#icsCreator').style.display = 'grid';
    }
});
document.querySelector("input[name='setStartTime']").oninput = function() {adaptTime()};
function adaptTime() {
    let start = document.querySelector("input[name='setStartTime']").value;
    var hours = start.slice(0,2);
    var minutes = start.slice(3,5);
    hours = Number(hours);
    console.log(hours + 1);
    if (hours < 9) {
        hours += 1
        hours = "0" + hours;
    } else if (hours === 0) {
        hours = "01";
    }
    document.querySelector("input[name='setEndTime']").value = hours + ":" + minutes;
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
    document.getElementById('auto_fill').style.display = 'flex';
    var cover = document.getElementById('cover');
    var val_input = document.querySelector('input[name="email"]').value;
    var mail_input = document.querySelector('input[name="email"]');
    var options_menu = document.querySelector('#auto_fill');
    var del_whitespace = val_input.replace(/\s/g,'');
    var split_mail = del_whitespace.split(',');
    var pos = split_mail.length - 1;
    Object.keys(lijst).forEach((key, index) => {
        if (document.getElementById(key) !== null) {
            option = document.getElementById(key);
            option.parentNode.removeChild(option);
        }
        core = key.replace(/\s/g,'');
        var re = new RegExp(`\\b${split_mail[pos]}`, `gi`);
        if (core.match(re) && !document.getElementById(key)) {
            text = document.createTextNode(key);
            option = document.createElement('p');
            cover.style.display = 'flex';
            mail_input.style.zIndex = 3;
            cover.addEventListener("click", () => {
                cover.style.display = 'none';
                option.style.zIndex = 1;
                document.getElementById('auto_fill').style.display = 'none';
                mail_input.style.zIndex = 1;
            });
            option.addEventListener("click", function(){
                setInput(split_mail,pos,lijst,key,val_input);    
            });
            option.id = key;
            option.value = lijst[key];
            option.classList.add('custom_option');
            option.classList.add('p-1', 'border-b-2', 'border-black', 'rounded-full', 'py-2', 'px-4', 'cursor-pointer');
            option.style.backgroundColor = '#CBF7ED';
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