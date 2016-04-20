function init() {
  activateCarousels();  
}

function activateCarousels () {
  var radios = document.querySelectorAll('.carousel-radios input'),
      i = 0,
      l = radios.length;
  if(l) {
    if(l > 1) { // if you have more than one card, add back and forward buttons for sited users
      activateForwardAndBack(radios, l);
    }
    for(i = 0; i < l; i++) {
      radios[i].addEventListener('change', function (e) {
        carouselChange(e.target.name, e.target.value);
      })
    }
  }
}

function activateForwardAndBack(){
  var arrowButtons = document.querySelectorAll('.carousel [data-move]'),
    i = 0, 
    l = arrowButtons.length;
  for (; i < l; i++) {
    arrowButtons[i].removeAttribute('hidden');
    arrowButtons[i].setAttribute('tabindex', '0');
    arrowButtons[i].addEventListener('click', function(e) {
      moveForwardOrBack(e);
    });
    arrowButtons[i].addEventListener('keyup', function(e) {
      if(e.keyCode == 13) {
        moveForwardOrBack(e);
      }
    });
  }
}

function moveForwardOrBack(e) {
      var name = e.target.dataset.carousel;
      console.log(name);
      var buttons = document.querySelectorAll('input[name=' + name + ']'),
          move = (e.target.dataset.move == 'forward') ? 1 : -1,
          selectedButton = +document.querySelector('input[name=' + name + ']:checked').value,
          newValue = (buttons.length + selectedButton + move) % buttons.length;
      buttons[newValue].checked = true;
      carouselChange(name, newValue);
}

function carouselChange (name, value) {
  name = 'carousel-content';
  console.log(value);
  var ul = document.querySelector('.' + name);
  ul.setAttribute('class', name + ' left' + value);
}

window.onload = function () {init();};