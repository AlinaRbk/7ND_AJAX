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
