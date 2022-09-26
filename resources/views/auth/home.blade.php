@extends('layout.app')
@section('content')

<div class="p-3">
    <!-- Button trigger modal -->
    @if (Auth::user()->status == 1)
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Crear artículo
    </button>
    @endif

    {{ Auth::user()->name}}
    <form id="articleForm">
        @csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Registra un nuevo artículo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Título</label>
                            <input type="text" class="form-control" name="title" placeholder="Ingresa el título">
                            <div class="form-text">Crea tu nuevo artículo con un tema llamativo</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Descripción</label>
                            <textarea class="form-control"" name=" description" placeholder="Ingresa una descripción"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="createArticle()">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="row" id="content">
    </div>

    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModal" aria-hidden="true">
        {{method_field('PUT')}}
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModal">Actualizar artículo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Título</label>
                        <input type="hidden" id="m_id">
                        <input type="text" class="form-control" placeholder="Ingresa el título" id="m_title">
                        <div class="form-text">Crea tu nuevo artículo con un tema llamativo</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Descripción</label>
                        <textarea class="form-control" placeholder="Ingresa una descripción" id="m_description"></textarea>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="m_status" checked>
                        <label class="form-check-label" for="status">Estado</label>
                        <div class="form-text">Deseleccione este botón para despublicar el artículo</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="updateArticle()">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModal">Borrar artículo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">¿Desea eliminar el artículo llamado ...?</label>
                        <input type="text" class="form-control" placeholder="Ingresa el título" id="delete_title" readonly>
                    </div>

                    <div class="mb-3">
                        <input type="hidden" id="delete_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="deleteArticle()">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        listArticles();
    }
    async function createArticle() {
        let form = document.getElementById('articleForm');
        let formData = new FormData(form);
        const response = await fetch('/article/store', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        if (data.success) {
            console.log(data);
            alert(data.success);
            listArticles();
        } else {
            alert('Error al crear el articulo');
        }
    }

    async function listArticles() {
        const response = await fetch('/article/list');
        const data = await response.json();
        if (data.length == 0) {
            document.getElementById('content').innerHTML = `
            <div class="col-md-12">
                <div class="container">
                    <section class="mx-auto my-5" style="max-width: 23rem;">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">No hay artículos</h5>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            `;
        } else {
            listCards(data);
        }
    }


    function listCards(articles) {
        let content = document.getElementById('content');

        content.innerHTML = '';
        for (let article of articles) {
            content.innerHTML += ` 
        <div class="col-md-4">
            <div class="container">
            <section class="mx-auto my-5" style="max-width: 23rem;">
      <div class="card">
        <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
          <img src="https://www.hostingplus.pe/wp-content/uploads/2021/03/desktop-source-code-and-wallpaper-by-computer-language-with-coding-and-programming.jpg" class="img-fluid" />
          <a href="#!">
            <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
          </a>
        </div>
        <div class="card-body">
          <h5 class="card-title font-weight-bold"><a>${article.title}</a></h5>
        
          <p class="card-text">
           ${article.description}
          </p>
          <p>Creado el ${article.created_at}</p>
          <hr class="my-4" />
          <button type="button" onClick="showUpdateModal('${article.id}')" class="btn btn-primary">Actualizar</button>
          <button type="button" onClick="showDeleteModal('${article.id}')" class="btn btn-danger">Eliminar</button>
        </div>
      </div>
      
    </section>
            </div>
        </div>
        `;
        }
    }

    async function showUpdateModal(id) {
        var updateModal = new bootstrap.Modal(document.getElementById('updateModal'), {
            keyboard: false
        });
        let article = await getArticle(id);
        setValues(article);
        updateModal.show();
    }

    function setValues(article) {
        document.getElementById('m_id').value = article.id;
        document.getElementById('m_title').value = article.title;
        document.getElementById('m_description').innerHTML = article.description;

        if (article.status == 1) {
            document.getElementById('m_status').checked = true;
        } else {
            document.getElementById('m_status').checked = false;
        }
    }

    async function updateArticle() {
        const token = document.querySelector('meta[name="csrf-token"]').content;

        let id = document.getElementById('m_id').value;
        let title = document.getElementById('m_title').value;
        let description = document.getElementById('m_description').value;
        let status = document.getElementById('m_status').checked;

        const request = await fetch(`/article/update`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-TOKEN": token
            },
            body: JSON.stringify({
                id: id,
                title: title,
                description: description,
                status: status
            })
        });
        const data = await request.json();
        if (data.success) {
            alert(data.success);
            listArticles();
        } else {
            alert('Error al actualizar el articulo');
        }

    }

    async function getArticle(id) {
        const response = await fetch(`/article/list/${id}`);
        const data = await response.json();
        return data;
    }

    async function showDeleteModal(id) {
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'), {
            keyboard: false
        });
        let article = await getArticle(id);
        document.getElementById('delete_id').value = article.id;
        document.getElementById('delete_title').value = article.title;
        deleteModal.show();
    }

    async function deleteArticle() {
        const id = document.getElementById('delete_id').value;
        const token = document.querySelector('meta[name="csrf-token"]').content;
        const request = await fetch(`/article/delete/${id}`, {
            method: 'DELETE',
            headers: {
                "X-CSRF-TOKEN": token
            }
        });
        if (request.status == 200) {
            alert('Articulo eliminado');
            listArticles();
        } else {
            alert('Error al eliminar el articulo');
        }

    }
</script>
@endsection