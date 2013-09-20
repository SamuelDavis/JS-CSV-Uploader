<html>
<head>
	<title>CSV Uploader</title>
	<style type="text/css">
		#error {
			background-color: pink;
		}
		table, th, td {
			border: 1px solid black;
			border-collapse: collapse;
		}
	</style>
</head>
<body>
	<label>Upload CSV</label>
	<br>
	<input type="file" id="upload_csv"></input>
	<span id="error"></span>

	<div id="csv_table"></div>

	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript">
		function generateTable(csvData) {

			//start generating table html
			tableHTML = "<table><thead></thead><tbody>";
			//get a handle on each row in the csv
			csvData.split("\n").forEach(function(row) {
				//add a row
				tableHTML += "<tr>";
				//get a handle on each element in the row
				row.split(", ").forEach(function(cell) {
					tableHTML += "<td>" + cell + "</td>";
				});
				tableHTML += "</tr>";
			});
			tableHTML += "</tbody></table>";

			//display table
			$("#csv_table").html(tableHTML);
		}

		$(function() {
			//On CSV upload
			$("#upload_csv").on("change", function(evt) {
				//If the file wasn't a .csv, display error and clear the input
				var file = evt.target.files[0];
				var filetype = file.name.split(".").pop();
				if(filetype !== "csv") {
					$("#error").html("File must be a .csv.");
					$(this).val("");
				} else {
					//Clear any error text and any data in the CSV table
					$("#error").html("");
					$("#csv_table").html("");

					//user the FileReader to get a handle on the .csv
					var reader = new FileReader();
					reader.readAsText(file, "UTF-8");

					//handle successful read
					reader.onload = function(evt) {
						generateTable(evt.target.result);
					};
					//handle unsuccessful read
					reader.onerror = function(evt) {
						$("#error").html("Error reading file.");
					};

				}

			});
		});
	</script>
</body>
</html>