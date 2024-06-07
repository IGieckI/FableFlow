let lastSelectedOption = null;

function poolUserViewInitialization(pool) {
    $.ajax({
        type: "GET",
        url: "/FableFlow/src/server/api/GetPoolInformations.php",
        data: { poolId: pool.pool_id },
        success: function(response) {
            try {
                response = JSON.parse(response);

                // Initialize the pool view
                document.getElementById("pool-title").textContent = pool.title;
                const optionsContainer = document.getElementById("pool-form");
                
                optionsContainer.innerHTML = '';

                response.options.forEach((option, index) => {
                    let optionElement = document.createElement("div");
                    optionElement.className = "form-check";
                    optionElement.innerHTML = `
                        <input class="form-check-input"${option.option_id == response.userChosenOption.option_id ? "checked=true," : ""} type="radio" name="poolOption" id="pool-option-${index}" value="${option.content}">
                        <label class="form-check-label" for="poolOption${index}">
                            ${option.content}
                        </label>`;
                    
                    document.getElementById('pool-form').appendChild(optionElement);
                                        
                    document.getElementById("pool-option-"+index).addEventListener('click', function() {
                        handleChoice(this, option.option_id);
                    });
                });

                if (response.userChosenOption != null) {
                    lastSelectedOption = document.querySelector(`input[value="${response.userChosenOption.content}"]`);
                }
            } catch (e) {
                console.error("Error parsing response: ", e);
            }
        },
        error: function(error) {
            console.log("Error loading user pool choices: " + error);
        }
    });
}


function handleChoice(element, optionId) {
    if (lastSelectedOption === element) {
        element.checked = false;
        lastSelectedOption = null;
        removeSelection(optionId);
    } else {
        lastSelectedOption = element;
        addSelection(optionId,  element.value);
    }
}

function addSelection(optionId, selectedOption) {
    $.ajax({
        type: "POST",
        url: "/FableFlow/src/server/api/PostUserPoolChoice.php",
        data: { optionId: optionId },
        success: function(response) {
            
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function removeSelection(optionId) {
    $.ajax({
        type: "POST",
        url: "/FableFlow/src/server/api/RemoveUserPoolChoice.php",
        data: { optionId: optionId },
        success: function(response) {
            
        },
        error: function(error) {
            console.log("Error clearing selection: " + error);
        }
    });
}