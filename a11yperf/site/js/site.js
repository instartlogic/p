function init() {
  //activateLanguageSelector();
  focusblurEvents();
  activateLanguageSelector();
  selectLanguage();
  activateCarousels();  
  cardFlip();
}

function cardFlip() {
  var cvv = document.getElementById('cvv');
  if(cvv) {
    cvv.addEventListener('focus', function(){
      var cardflip = document.getElementById('cardflip');
      cardflip.classList.add('cvv');
    });
    cvv.addEventListener('blur', function(){
      var cardflip = document.getElementById('cardflip');
      cardflip.classList.remove('cvv');
    });
  }
}

function activateLanguageSelector () {
  var openclose = document.querySelector('#languageIndicator > a');
  if(openclose){
    openclose.addEventListener('click', function() {
        opencloseLanguageSelector();
    });
  }
}

function opencloseLanguageSelector () {
    var oc = document.getElementById('languageOpenClose'),
        footer = document.getElementsByTagName('footer')[0];
    oc.classList.toggle('up');
    oc.classList.toggle('down');
    footer.classList.toggle('open');
    footer.classList.toggle('closed');
}

function selectLanguage () {
  var radios = document.querySelectorAll('#languageSelector input'),
      i;

  for (i = 0; i < radios.length; i++) {
    radios[i].addEventListener('click', function (e) {
        // change the country
        var country = e.target.value;
        document.getElementById('languageFlag').setAttribute('class', "lang" + country + " icon");
        // close the country 
        opencloseLanguageSelector();
    })
  }  
}

function focusblurEvents () {
 var actionItems = document.querySelectorAll('.formControl input'),
      i;

  for (i = 0; i < actionItems.length; i++) {
    actionItems[i].addEventListener('blur', function(e){changeClassBlur(e);});
    actionItems[i].addEventListener('focus', function(e){changeClassFocus(e);});
  }
}

function changeClassFocus (e) {
  var id = e.target.id;
  var label = document.querySelector('[for=' + id + ']');

  label.classList.add('focus');
  label.classList.remove('empty');
}

function changeClassBlur (e) {
  var id = e.target.id,
    label = document.querySelector('[for=' + id + ']');

  label.classList.remove('focus');
  if(!e.target.value) {
    label.classList.add('empty');
  }
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
        //carouselChange(e);
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
    arrowButtons[i].addEventListener('click', function(e) {
      var name = e.target.dataset.carousel,
          buttons = document.querySelectorAll('input[name=' + name + ']'),
          move = (e.target.dataset.move == 'forward') ? 1 : -1,
          selectedButton = +document.querySelector('input[name=' + name + ']:checked').value,
          newValue = (buttons.length + selectedButton + move) % buttons.length;
      buttons[newValue].checked = true;
      carouselChange(name, newValue);
    });
  }

}

function carouselChange (name, value) {
  var ul = document.querySelector('.' + name);
  ul.setAttribute('class', name + ' left' + value);
}

window.onload = function () {init();};