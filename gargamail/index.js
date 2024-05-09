const searchInput = document.getElementById("bar");

        const namesFromDOM = document.getElementsByClassName("content");
        const zadeve = document.getElementsByClassName("SamoZadeva");

        searchInput.addEventListener("keyup", (event) => {
            const { value } = event.target;
            
            const searchQuery = value.toLowerCase();
            
            for (const nameElement of namesFromDOM) {
                let name = nameElement.textContent.toLowerCase();
                
                if (name.includes(searchQuery)) {
                    nameElement.style.display = "flex";
                } 
                else {
                    nameElement.style.display = "none";
                }
            }
        });
//VSE TO JE ZA SEARCH
        