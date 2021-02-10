const submit = document.querySelector('.submit');
const find = document.querySelector('.find');
const input = document.querySelector('.input');
const form = document.querySelector('form');
const wrap = document.querySelector('.wrap');

const findTrailer = () => {
  movieTrailer(input.value.toLowerCase())
    .then((res) => {
        const url = res.replace('watch?v=', 'embed/');
        const input = document.createElement('input');
        const wrapper = document.createElement('div');

        input.value = url;
        wrapper.setAttribute('class', 'mui-textfield');
        input.setAttribute('name', 'Video');
        wrapper.append(input);
        wrap.append(wrapper);
      }
    )
    .catch((error) => {
      alert(error)
    });
};

const findMovieInfo = () => {
  fetch(`https://www.omdbapi.com/?apikey=a0047264&t=${input.value}&plot=full`)
    .then(response => response.json())
    .then(data => renderData({...data}))
    .then(() => findTrailer())
};

const translate = (input, value) => {

  const data = JSON.stringify({
    "q": `${value}`,
    "source": "en",
    "target": "pt"
  });
  const xhr = new XMLHttpRequest();
  xhr.withCredentials = true;
  xhr.addEventListener("readystatechange", function () {
    if (this.readyState === this.DONE) {
      const res = JSON.parse(this.responseText);
      input.value = res.data.translations.translatedText;
    }
  });
  xhr.open("POST", "https://deep-translate1.p.rapidapi.com/language/translate/v2");
  xhr.setRequestHeader("content-type", "application/json");
  xhr.setRequestHeader("x-rapidapi-key", "6d291bb001msh74f879e7cae0d1ep1a2a38jsnfdb0b0ba682d");
  xhr.setRequestHeader("x-rapidapi-host", "deep-translate1.p.rapidapi.com");
  xhr.send(data);
};

const renderData = (content) => {
  for (let [key, value] of Object.entries(content)) {
    const input = document.createElement('input');
    const textField = document.createElement('div');


    textField.setAttribute('class', 'mui-textfield');
    input.setAttribute('type', 'text');


    input.setAttribute('name', key);
    input.value = value;


    if (key === 'Plot' || key === 'Title' || key === 'Awards') {
      translate(input, value)
    }


    if (key === 'Genre') {
      let arr = value.split(', ');

      translate(input, arr[0])
    }

    textField.append(input);
    wrap.append(textField)
  }
};

submit.addEventListener('click', async (e) => {
  e.preventDefault();
  form.submit();
});
find.addEventListener('click', async (e) => {
  e.preventDefault();
  findMovieInfo();
});