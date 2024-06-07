<div id="form-container">
        <form id="pool-creation-form">
            <div class="form-group">
                <!--<label for="title">Title</label>-->
                <input type="text" id="title" name="title" placeholder="Give a meaningful title...">
            </div>
            <div class="form-group">
                <!--<label for="text">Text</label>-->
                <textarea id="text" name="text" rows="50" cols="50" placeholder="Explain the context..."></textarea>
            </div>
            <div class="form-group">
                <label for="expiration_datetime">Enter the deadline of the pool:</label>
                <input type="text" id="expiration_datetime" name="expiration_datetime" placeholder="yy-mm-dd HH:mm:ss">
            </div>
            <div class="form-group">
                <ul id="choices_list" class="choices-list">
                    <li id="input_pool">
                        <input type="text" id="text_option" name="text_option" placeholder="Choice goes here...">
                        <i style="display:none" id="add_option" class="bi bi-check"></i>
                    </li>
                </ul>
            </div>
            <div id="pool-create-buttons"class="form-buttons">
                <button class="btn custom-btn mb-5" type="submit" id="submitButton">Confirm</button>
                <button class="btn custom-btn mb-5" type="button" id="clearButton">Clear</button>
            </div>
        </form>
    </div>