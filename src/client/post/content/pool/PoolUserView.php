<div class="container">
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
                <h1 id="pool-title" class="mb-0 d-inline-block"></h1>
                <span id="pool-time" class="ml-2 text-muted"></span>
            </div>
            <div class="ml-auto">
                <-- TOGLIERE ->
            </div>
        </div>
        <form id="pollForm">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="pollOption" id="option1" value="Python" onclick="handleChoice(this)">
                <label class="form-check-label" for="option1">
                    Python
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="pollOption" id="option2" value="JavaScript" onclick="handleChoice(this)">
                <label class="form-check-label" for="option2">
                    JavaScript
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="pollOption" id="option3" value="Java" onclick="handleChoice(this)">
                <label class="form-check-label" for="option3">
                    Java
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="pollOption" id="option4" value="C++" onclick="handleChoice(this)">
                <label class="form-check-label" for="option4">
                    C++
                </label>
            </div>
        </form>
    </div>