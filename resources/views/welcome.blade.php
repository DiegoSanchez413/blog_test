<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel</title>
  @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>

<body>
  <div class=p-4>
    <div class="row">
      <div class="col-md-6">
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="search" placeholder="Ingrese una palabra" aria-label="Ingrese una palabra" aria-describedby="button-addon2">
          <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="searchByText()">Buscar</button>
        </div>
        <div class="form-text">Ingrese sílabas para buscar las apis que la contengan</div>

      </div>
      <div class="col-md-6">
        <button type="button" class="btn btn-primary" onclick="getRandomAPI()">Obtener API Random</button>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <p id="count_search"></p>
        <ul class="list-group" id="list">

        </ul>
      </div>
      <div id="content" class="mt-3 col-md-6">
        <ul>

        </ul>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h3>Categorias de API's</h3>
        <div id="categories">

        </div>
      </div>
    </div>
  </div>


  <script>
    window.addEventListener('DOMContentLoaded', () => {
      listCategories();
    });

    const content = document.getElementById('content');
    const list = document.getElementById('list');
    const categories = document.getElementById('categories');
    async function getRandomAPI() {
      const response = await fetch('/random-item');
      const data = await response.json();
      const item = data.entries[0];
      updateCard(item);
    }

    function updateCard(data) {
      content.innerHTML = '';
      content.innerHTML += ` 
        <div class="card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title">${data.API}</h5>
        <p class="card-text">${data.Description}</p>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">Categoría ${data.Category}</li>
        <li class="list-group-item">Cors ${data.Cors}</li>
        <li class="list-group-item">Autenticación ${data.Auth}</li>
        <li class="list-group-item">HTTPS ${data.HTTPS}</li>
      </ul>
      <div class="card-body">
        <a href="${data.Link}" target="_blank" class="card-link">Link</a>
      </div>
    </div>
        `;
    }

    async function searchByText() {
      let text = document.getElementById('search').value;
      const response = await fetch(`/search-by-text/${text}`);
      const data = await response.json();
      document.getElementById('count_search').innerHTML = `Se encontraron ${data.length} apis`;
      buildList(data);
    }

    function buildList(data) {
      list.innerHTML = '';
      for (let item of data) {
        list.innerHTML += ` 
      <li class="list-group-item">${item.API} - enlace aquí  <a href="${item.Link}" target="_blank" class="card-link">Link</a></li>
        `;
      }
    }


    async function listCategories() {
      const response = await fetch('/list-categories');
      const data = await response.json();
      buildBadgesList(data);
    }

    function buildBadgesList(data) {
      let categories = document.getElementById('categories');
      categories.innerHTML = '';

      for (let item of data.categories) {
        categories.innerHTML += ` 
      <span style="cursor:pointer" onclick="getAPIByCategory('${item}')" class="badge bg-${randomColor()}">${item}</span>
        `;
      }
    }

    function randomColor() {
      let array = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark'];
      let random = Math.floor(Math.random() * array.length);
      console.log(array[random]);
      return array[random];
    }

    async function getAPIByCategory(category) {
      const response = await fetch(`/search-by-category/${category}`);
      const data = await response.json();
      document.getElementById('count_search').innerHTML = `Se encontraron ${data.length} apis con respecto a la categoría <b>${category}</b>`;
      buildList(data);
    }
  </script>

</body>

</html>