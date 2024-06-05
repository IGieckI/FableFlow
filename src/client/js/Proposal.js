function updateProposalLike(proposalId) {
    $.ajax({
        type: "POST",
        url: "/FableFlow/src/server/api/UpdateProposalLike.php",
        data: { proposalId: proposalId },
        success: function(response) {
            response = JSON.parse(response);            
            console.log(response);
            document.getElementById("proposal-like-span").innerHTML = response["likes"];
            document.getElementById("proposal-like-icon").className = response["status"] == 0 ? "bi bi-fire" : "bi bi-fire like-clicked";
        },
        error: function() {
            console.log("Error updating likes.");
        }
    });
}