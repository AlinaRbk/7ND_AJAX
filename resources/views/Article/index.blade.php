@extends('layouts.app')

@section('content')

<style>
th div {
  cursor: pointer;
}
</style>  

<div class="container">
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createArticleModal">
    Create article
</button>

    <input id="hidden-sort" type="hidden" value="id" />
    <input id="hidden-direction" type="hidden" value="asc" />

<div id="alert" class="alert alert-success d-none">
    </div>   

<div class="searchAjaxForm">
    <input id="searchValue" type="text">
    <span class="search-feedback"></span>
</div>

<!-- MODAL -->

<div class="modal fade" id="createArticleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Modal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="ajaxForm">
                    <div class="form-group">
                        <label for="article_title">Article Title</label>
                        <input id="article_title" class="form-control" type="text" name="article_title" />
                    </div>
                    <div class="form-group">
                        <label for="article_description">Article Description</label>
                        <input id="article_description" class="form-control" type="text" name="article_description" />
                     </div>
                    <div class="form-group">
                        <label for="article_type_id">Article Type</label>
                        <select id="article_type_id" class="form-select" name="article_type_id">
                        @foreach($types as $type)
                        <option value="{{$type->id}}">{{$type->title}} </option>
                        @endforeach
                        </select>
                        <span class="invalid-feedback input_article_type_id"> </span> 
                    </div>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="submit-ajax-form" type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editArticleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Modal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="ajaxForm">
              <input type="hidden" id="edit_article_id" name="article_id" />
              <div class="form-group">
                  <label for="article_title">Article title</label>
                  <input id="edit_article_title" class="form-control" type="text" name="article_title" />
              </div>
              <div class="form-group">
                  <label for="article_description">Article Description</label>
                  <input id="edit_article_description" class="form-control" type="text" name="article_description" />
              </div>
              <div class="form-group">
                <label for="article_type_id">Article Type</label>
                <select id="edit_article_type_id" class="form-select">
                    @foreach ($types as $type)
                        <option class="type{{$type->id}}" value="{{$type->id}}">{{$type->title}}</option>
                    @endforeach
                 </select>  
              </div>
          </div> 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button id="update-article" type="button" class="btn btn-primary update-article">Update</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="showArticleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Show Article</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="show-article-id">
            </div>  
            <div class="show-article-title">
            </div>
            <div class="show-article-description">
            </div>
            <label>Type</label>
            <div class="show-article-type">
            </div>     
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

    <table id="articles-table" class="table table-striped">
    <thead>
        <tr>
            <th><div class="articles-sort" data-sort="id" data-direction="asc">ID</div></th>
            <th><div class="articles-sort" data-sort="title" data-direction="asc">Title</div></th>
            <th><div class="articles-sort" data-sort="description" data-direction="asc">Description</div></th>
            <th><div class="articles-sort" data-sort="aticleType.title" data-direction="asc">Type</div></th>
            <th>Action</th>
        </tr>
    </thead>
      <tbody>  
        @foreach ($articles as $article) 
        <tr class="article{{$article->id}}">
            <td class="col-article-id">{{$article->id}}</td>
            <td class="col-article-title">{{$article->title}}</td>
            <td class="col-article-description">{{$article->description}}</td>
            <td class="col-article-type">{{$article->articleType->title}}</td>
            <td>
            <button class="btn btn-danger delete-article" type="submit" data-articleId="{{$article->id}}">DELETE</button>
            <button type="button" class="btn btn-primary show-article" data-bs-toggle="modal" data-bs-target="#showArticleModal" data-articleId="{{$article->id}}">Show</button>
            <button type="button" class="btn btn-secondary edit-article" data-bs-toggle="modal" data-bs-target="#editArticleModal" data-articleId="{{$article->id}}">Edit</button>
            </td>
        </tr>
        @endforeach
    </tbody>  
    </table>
    <table class="template d-none">
        <tr>
          <td class="col-article-id"></td>
          <td class="col-article-title"></td>
          <td class="col-article-description"></td>
          <td class="col-article-type"></td>

          <td>
          <button class="btn btn-danger delete-article" type="submit" data-articleId="">DELETE</button>
            <button type="button" class="btn btn-primary show-article" data-bs-toggle="modal" data-bs-target="#showarticleModal" data-articleId="">Show</button>
            <button type="button" class="btn btn-secondary edit-article" data-bs-toggle="modal" data-bs-target="#editarticleModal" data-articleId="">Edit</button>
          </td>
        </tr>  
    </table>  


</div>

<script>

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
    }
});


function createRow(articleId, articleTitle, articleDescription) {
        let html
        html += "<tr class='article"+articleId+"'>";
        html += "<td>"+articleId+"</td>";    
        html += "<td>"+articleTitle+"</td>";  
        html += "<td>"+articleDescription+"</td>";  
        html += "<td>";
        html +=  "<button class='btn btn-danger delete-article' type='submit' data-articleid='"+articleId+"'>DELETE</button>"; 
        html +=  "</td>";
        html += "</tr>";
        return html 
    }
    function createRowFromHtml(articleId, articleTitle, articleDescription, articleType) {
        $(".template tr").removeAttr("class");
        $(".template tr").addClass("article"+articleId);
        $(".template .delete-article").attr('data-articleId', articleId );
        $(".template .show-article").attr('data-articleId', articleId );
        $(".template .edit-article").attr('data-articleId', articleId );
        $(".template .col-article-id").html(articleId );
        $(".template .col-article-title").html(articleTitle );
        $(".template .col-article-description").html(articleDescription );
        $(".template .col-article-type").html(articleType );
          
        return $(".template tbody").html();
        }


    console.log("Jquery veikia");
        $("#submit-ajax-form").click(function() {
            let article_title;
            let article_description;
            let article_type_id;
            let sort;
            let direction;


            article_title = $('#article_title').val();
            article_description = $('#article_description').val();
            article_type_id = $('#article_type_id').val();
            sort = $('#hidden-sort').val();
            direction = $('#hidden-direction').val();
            
        $.ajax({
            type: 'POST',
            url: '{{route("article.storeAjax")}}' ,
            data: {article_title: article_title, article_description: article_description, article_type_id: article_type_id}, 
            success: function(data) {
                console.log(data);

                if($.isEmptyObject(data.errorMessage)) {
                      //sekmes atvejis
                      $("#articles-table tbody").html('');
                     $.each(data.articles, function(key, article) {
                          let html;
                          html = createRowFromHtml(article.id, article.title, article.description, article.article_type.title);
                          // console.log(html)
                          $("#articles-table tbody").append(html);
                     });

                //let html;
                    //let html = "<tr><td>"+data.articleId+"<tr><td>"+data.articleTitle+"<tr><td>"+data.articleDescription+"<tr><td>"+data.articleTypeid."</td></tr>";
                    
                    
                    //html = createRowFromHtml(data.articleId, data.articleTitle, data.articleDescription, data.articleType);
                   
                    $("#createArticleModal").hide();
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $('body').css({overflow:'auto'});

                    $("#alert").removeClass("d-none");
                    $("#alert").html(data.successMessage +" " + data.articleTitle +" " +data.articleDescription);
                   
                    $('#article_title').val('');
                    $('#article_description').val('');
               
                     } else {
                      console.log(data.errorMessage);
                      console.log(data.errors);
                      $('.create-input').removeClass('is-invalid');
                      $('.invalid-feedback').html('');

                      $.each(data.errors, function(key, error) {
                        console.log(key);//key = input id
                        $('#'+key).addClass('is-invalid');
                        $('.input_'+key).html("<strong>"+error+"</strong>");
                      });
                    }
                    
            }
        });
    });

    $(document).on('click', '.edit-article', function() {
          let articleid;
            articleid = $(this).attr('data-articleid');
            console.log(articleid);
            $.ajax({
                type: 'GET',// formoje method POST GET
                url: '/articles/showAjax/' + articleid  ,// formoje action
                success: function(data) {
                  $('#edit_article_id').val(data.articleId);                   
                   $('#edit_article_title').val(data.articleTitle);                   
                   $('#edit_article_description').val(data.articleDescription);
                   
                   $('#edit_article_type_id option').removeAttr('selected');
                   $('#edit_article_type_id').val(data.articleTypeId);
                   $('#edit_article_type_id .type'+ data.articleTypeId).attr("selected", "selected");                                 
                }
            });
        });

        $(document).on('click', '.update-article', function() {
          let articleid;
          let article_title;
            let article_description;
            let article_type_id;
          articleid = $('#edit_article_id').val();
          article_title = $('#edit_article_title').val();
          article_description = $('#edit_article_description').val();
          article_type_id = $('#edit_article_type_id').val();
          $.ajax({
                type: 'POST',// formoje method POST GET
                url: '/articles/updateAjax/' + articleid  ,// formoje action
                data: {article_title: article_title, article_description: article_description, article_type_id: article_type_id  },
                success: function(data) {
                  
                  $(".article"+articleid+ " " + ".col-article-title").html(data.articleTitle);
                  $(".article"+articleid+ " " + ".col-article-description").html(data.articleDescription);
                  $(".article"+articleid+ " " + ".col-article-type").html(data.articleTypeTitle);
                  
                    $("#alert").removeClass("d-none");
                    $("#alert").html(data.successMessage);
                    
                    $("#editArticleModal").hide();
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $('body').css({overflow:'auto'});
                }
            });
        });

        $(document).on('click', '.show-article', function() {
            let articleid;
            articleid = $(this).attr('data-articleid');
            console.log(articleid);
            $.ajax({
                type: 'GET',// formoje method POST GET
                url: '/articles/showAjax/' + articleid  ,// formoje action
                success: function(data) {
                   $('.show-article-id').html(data.articleId);                   
                   $('.show-article-title').html(data.articleTitle);                   
                   $('.show-article-description').html(data.articleDescription);                                  
                   $('.show-article-type').html(data.articleTypeTitle);                                  
                }
            });
        });

        $(document).on('click', '.delete-article', function() {
            let articleid;
            articleid = $(this).attr('data-articleid');
            console.log(articleid);
            $.ajax({
                type: 'POST',// formoje method POST GET
                url: '/articles/deleteAjax/' + articleid  ,// formoje action
                success: function(data) {
                   console.log(data);
                   $('.article'+articleid).remove();
                    $("#alert").removeClass("d-none");
                    $("#alert").html(data.successMessage);                    
                }
            });
        });

        $('.articles-sort').click(function() {
          let sort;
          let direction;
          sort = $(this).attr('data-sort');
          direction = $(this).attr('data-direction');
          $("#hidden-sort").val(sort);
          $("#hidden-direction").val(direction);
          if(direction == 'asc') {
            $(this).attr('data-direction', 'desc');
          } else {
            $(this).attr('data-direction', 'asc');
          }

          $.ajax({
                type: 'GET',
                url: '{{route("article.indexAjax")}}'  ,// formoje action
                data: {sort: sort, direction: direction },
                success: function(data) {
                  console.log(data.articles);
                    $("#articles-table tbody").html('');
                     $.each(data.articles, function(key, article) {
                          let html;
                          html = createRowFromHtml(article.id, article.title, article.description, article.article_type.title);
                          // console.log(html)
                          $("#articles-table tbody").append(html);
                     });
                }
            });
        });


        $(document).on('input', '#searchValue', function() {
          let searchValue = $('#searchValue').val();
          let searchFieldCount= searchValue.length;
          if(searchFieldCount == 0) {
            console.log("Field is empty");
            $(".search-feedback").css('display', 'block');
            $(".search-feedback").html("Field is empty");
          } else if (searchFieldCount != 0 && searchFieldCount< 3 ) {
            console.log("Min 3");
            $(".search-feedback").css('display', 'block');
            $(".search-feedback").html("Min 3");
          } else {
            $(".search-feedback").css('display', 'none');
          console.log(searchFieldCount);
          console.log(searchValue);
          
          $.ajax({
                type: 'GET',
                url: '{{route("article.searchAjax")}}'  ,
                data: {searchValue: searchValue},
                success: function(data) {

                  if($.isEmptyObject(data.errorMessage)) {
                    
                    $("#articles-table").show();
                    $("#alert").addClass("d-none");
                    $("#articles-table tbody").html('');
                     $.each(data.articles, function(key, article) {
                          let html;
                          html = createRowFromHtml(article.id, article.title, article.description, article.type_id);
                          $("#articles-table tbody").append(html);
                     });                             
                  } else {
                        $("#articles-table").hide();
                        $('#alert').removeClass('alert-success');
                        $('#alert').addClass('alert-danger');
                        $("#alert").removeClass("d-none");
                        $("#alert").html(data.errorMessage); 
                  }                            
                }
            });
          }
        });
    
</script>

@endsection