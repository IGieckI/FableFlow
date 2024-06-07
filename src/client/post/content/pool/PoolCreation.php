<div class="form-container">
        <form id="pool-creation-form">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title">
            </div>
            <div class="form-group">
                <label for="text">Text</label>
                <textarea id="text" name="text"></textarea>
            </div>
            <div class="form-group">
                <ul id="choices_list" class="choices-list">
                    <li id="input_pool">
                        <input type="text" id="text_option" name="text_option" placeholder="Text goes here...">
                        <i class="bi bi-trash"></i>
                        <i id="add_option" class="bi bi-check"></i>
                    </li>
                </ul>
            </div>
            <div class="form-buttons">
                <button type="submit">Confirm</button>
                <button type="button" id="clearButton">Clear</button>
            </div>
        </form>
    </div>