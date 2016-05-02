
var carouselCarousel = {

  arrowButtons: true, // set to false if no arrows on your carousel
  carouselID: '',

  init: function (id) {
    carouselCarousel.carouselID = id;
    carouselCarousel.activateCarousels();  
  },

  activateCarousels : function () {
    var radios = document.querySelectorAll('#' + carouselCarousel.carouselID +' input[type="radio"]'),
        i = 0,
        l = radios.length;
    if(l && carouselCarousel.arrowButtons) {
      if(l > 1) { // if you have more than one card, add back and forward buttons for sited users
        carouselCarousel.activateForwardAndBack();
      }
      for(i = 0; i < l; i++) {
        radios[i].addEventListener('change', function (e) {
          console.log('change')
          carouselCarousel.carouselChange(e.target.name, e.target.dataset.value);
        })
      }
    }
  },

  // Activate arrows if there is more than one item and arrows are included
  activateForwardAndBack: function () {
    console.log(arguments.length);
    var arrowButtons = document.querySelectorAll('#' + carouselCarousel.carouselID +' [data-move]'),
        l = arrowButtons.length;
    for (var i = 0; i < l; i++) {
      console.log(i + ' ' + l);
      arrowButtons[i].removeAttribute('hidden');
      arrowButtons[i].setAttribute('tabindex', '0');
      arrowButtons[i].addEventListener('click', function(e) {
        carouselCarousel.moveForwardOrBack(e);
      });
      arrowButtons[i].addEventListener('keyup', function(e) {
        if(e.keyCode == 13) {
          carouselCarousel.moveForwardOrBack(e);
        }
      });
    }
  },

  moveForwardOrBack: function (e) {
        var name = e.target.dataset.carousel,
            buttons = document.querySelectorAll('input[name=' + name + ']'),
            move = (e.target.dataset.move == 'forward') ? 1 : -1,
            selectedButton = +document.querySelector('input[name=' + name + ']:checked').dataset.value,
            newValue = (buttons.length + selectedButton + move) % buttons.length;
        buttons[newValue].checked = true;
        carouselCarousel.carouselChange(name, newValue);
  },

  carouselChange: function (name, value) {
    name = 'carousel-labels';
    var ul = document.querySelector('.' + name);
    ul.setAttribute('class', name + ' left' + value);
  }
}