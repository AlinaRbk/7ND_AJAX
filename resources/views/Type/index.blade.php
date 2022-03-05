@extends('layouts.app')

@section('content')

<div class="container">
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTypeModal">
    Create type
</button>

<!-- MODAL -->

<div class="modal fade" id="createTypeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Modal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="ajaxForm">
                    <div class="form-group">
                        <label for="type_title">Type Title</label>
                        <input id="type_title" class="form-control" type="text" name="type_title" />
                    </div>
                    <div class="form-group">
                        <label for="type_description">Type Description</label>
                        <input id="type_description" class="form-control" type="text" name="type_description" />
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
<div class="modal fade" id="editTypeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Modal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="ajaxForm">
              <input type="hidden" id="edit_type_id" name="type_id" />
              <div class="form-group">
                  <label for="type_title">Type title</label>
                  <input id="edit_type_title" class="form-control" type="text" name="type_title" />
              </div>
              <div class="form-group">
                  <label for="type_description">Type Description</label>
                  <input id="edit_type_description" class="form-control" type="text" name="type_description" />
              </div>
          </div> 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              {{-- <button id="close-type-create-modal" type="button" class="btn btn-secondary">Close with Javascript</button> --}}
              <button id="update-type" type="button" class="btn btn-primary">Update</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="showTypeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Show Type</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="show-type-id">
              </div>  
              <div class="show-type-title">
              </div>  
              <div class="show-type-description">
              </div>    
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>


    <div id="alert" class="alert alert-success d-none">
    </div>  

    <table id="types-table" class="table table-striped">
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Description</th>
        </tr>
        @foreach ($types as $type) 
        <tr class="type{{$type->id}}">
            <td class="col-type-id">{{$type->id}}</td>
            <td class="col-type-title">{{$type->title}}</td>
            <td class="col-type-description">{{$type->description}}</td>
            <td>
            <button class="btn btn-danger delete-type" type="submit" data-typeid="">DELETE</button>
            <button type="button" class="btn btn-primary show-type" data-bs-toggle="modal" data-bs-target="#showTypeModal" data-typeid="{{$type->id}}">Show</button>
            <button type="button" class="btn btn-secondary edit-type" data-bs-toggle="modal" data-bs-target="#editTypeModal" data-typeid="{{$type->id}}">Edit</button>
            </td>
        </tr>
        @endforeach
    </table>
    <table class="template">
        <tr>
          <td class="col-type-id"></td>
          <td class="col-type-title"></td>
          <td class="col-type-description"></td>
          <td>
          <button class="btn btn-danger delete-type" type="submit" data-typeid="">DELETE</button>
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

$(document).ready(function() {
    $("#remove-table").click(function(){
          $('.type5').remove();
    });

    function createRow(typeId, typeTitle, typeDescription ) {
        let html
        html += "<tr class='type"+typeId+"'>";
        html += "<td>"+typeId+"</td>";    
        html += "<td>"+typeTitle+"</td>";  
        html += "<td>"+typeDescription+"</td>";  
        html += "<td>";
        html +=  "<button class='btn btn-danger delete-type' type='submit' data-typetid='"+typeId+"'>DELETE</button>"; 
        html +=  "</td>";
        html += "</tr>";
        return html 
    }
        function createRowFromHtml(typeId, typeTitle, typeDescription) {
          $(".template tr").addClass("type"+typeId);
          $(".template .delete-type").attr('data-typeid', typeId );
          $(".template .show-type").attr('data-typeid', typeId );
          $(".template .edit-type").attr('data-typeid', typeId );
          $(".template .col-type-id").html(typeId );
          $(".template .col-type-title").html(typeTitle );
          $(".template .col-type-description").html(typeDescription );
          
          return $(".template tbody").html();
        }

        console.log("Jquery veikia");
        $("#submit-ajax-form").click(function() {
            let type_title;
            let type_description;

            type_title = $('#type_title').val();
            type_description = $('#type_description').val();

            $.ajax({
                type: 'POST',
                url: '{{route("type.storeAjax")}}' ,
                data: {type_title: type_title, type_description: type_description  },
                    success: function(data) {
                        console.log(data);
                        let html;

                    html = createRowFromHtml(data.typetId, data.typeTitle, data.typeDescription);
                    $("#types-table").append(html);

                    $("#createTypeModal").hide();
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $('body').css({overflow:'auto'});

                    $("#alert").removeClass("d-none");
                    $("#alert").html(data.successMessage +" " + data.typeTitle +" " +data.typeDescription);
                    
                    $('#type_title').val('');
                    $('#type_description').val('');
                }
            });
    });
        $(document).on('click', '.delete-type', function() {
            let typeid;
            typeid = $(this).attr('data-typeid');
            console.log(typeid);
            $.ajax({
                type: 'POST',
                url: '/types/deleteAjax/' + typeid  ,
                success: function(data) {
                   console.log(data);

                    $('.type'+typeid).remove();
                    $("#alert").removeClass("d-none");
                    $("#alert").html(data.successMessage);                    
                }
            });
        });
        $(document).on('click', '.show-type', function() {
            let typetid;
            typetid = $(this).attr('data-typeid');
            console.log(typeid);

            $.ajax({
                type: 'GET',// formoje method POST GET
                url: '/types/showAjax/' + typeid  ,// formoje action
                success: function(data) {
                   $('.show-type-id').html(data.typeId);                   
                   $('.show-type-title').html(data.typeName);                                
                   $('.show-type-description').html(data.typeDescription);                                  
                }
            });
        });    

        $(document).on('click', '.edit-type', function() {
            let typeid;
                typeid = $(this).attr('data-typeid');
                console.log(typeid);
                $.ajax({

                    type: 'GET',// formoje method POST GET
                    url: '/types/showAjax/' + typeid  ,// formoje action
                    success: function(data) {
                    $('#edit_type_id').val(data.typeId);                   
                    $('#edit_type_title').val(data.typeTitle);                                  
                    $('#edit_type_description').val(data.typeDescription);                                  
                }
            });
        });
})
</script>


@endsection   