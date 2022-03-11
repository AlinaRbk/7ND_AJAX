@extends('layouts.app')

@section('content')

<div class="container">
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createArticleModal">
    Create article
</button>

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
                        <select id="article_type_id" class="form-select create-input">
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



</div>

    <table id="articles-table" class="table table-striped">
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Description</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
        @foreach ($articles as $article) 
        <tr class="article{{$article->id}}">
            <td class="col-article-id">{{$article->id}}</td>
            <td class="col-article-title">{{$article->title}}</td>
            <td class="col-article-description">{{$article->description}}</td>
            <td class="col-article-type">{{$article->articleType->title}}</td>
            <td>
            <button class="btn btn-danger delete-article" type="submit" data-articleId="{{$article->id}}">DELETE</button>
            <button type="button" class="btn btn-primary show-article" data-bs-toggle="modal" data-bs-target="#showArticleModal" data-articleId="{{$article->id}}">Show</button>
            <button type="button" class="btn btn-secondary edit-article" data-bs-toggle="modal" data-bs-target="#editArticleModal" data-articleId="{{$carticle->id}}">Edit</button>
            </td>
        </tr>
        @endforeach
    </table>
    <table class="template">
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
    function createRowFromHtml(articleId, articleTitle, articleDescription, articleTypeId) {
        $(".template tr").removeAttr("class");
        $(".template tr").addClass("article"+articleId);
        $(".template .delete-article").attr('data-articleId', articleId );
        $(".template .show-article").attr('data-articleId', articleId );
        $(".template .edit-article").attr('data-articleId', articleId );
        $(".template .col-article-id").html(articleId );
        $(".template .col-article-title").html(articleTitle );
        $(".template .col-article-description").html(articleDescription );
        $(".template .col-article-type").html(articleTypeId );
          
        return $(".template tbody").html();
        }


    console.log("Jquery veikia");
        $("#submit-ajax-form").click(function() {
            let article_title;
            let article_description;
            let article_type_id;

            article_title = $('#article_title').val();
            article_description = $('#article_description').val();
            article_type_id = $('#article_type_id').val();
            
        $.ajax({
            type: 'POST',
            url: '{{route("article.storeAjax")}}' ,
            data: {article_title: article_title, article_description: article_description, article_type_id: article_type_id}, 
            success: function(data) {
                console.log(data);
                let html;
                    //let html = "<tr><td>"+data.articleId+"<tr><td>"+data.articleTitle+"<tr><td>"+data.articleDescription+"<tr><td>"+data.articleTypeid."</td></tr>";
                    
                    
                    html = createRowFromHtml(data.articleId, data.articleTitle, data.articleDescription, data.articleTypeId);
                    $("#articles-table").append(html);

                    $("#createArticleModal").hide();
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $('body').css({overflow:'auto'});

                    $("#alert").removeClass("d-none");
                    $("#alert").html(data.successMessage +" " + data.articleTitle +" " +data.articleDescription+" " +data.articleTypeId);
                   
                    $('#article_title').val('');
                    $('#article_description').val('');
                    
            }
        });
    });

</script>

@endsection