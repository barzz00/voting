<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>SSG Voting System</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <link href="http://fonts.googleapis.com/css?family=Ubuntu|Raleway|Oswald|Roboto+Condensed" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
  </head>
  <body>

  <div class="container">
  <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container-fluid"> 


    <!-- Mobile Toggle -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-main" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      
      <a href="cpanel.php" class="navbar-brand">
        <img src="images/sis.png" alt="SIS Logo" width="50" height="50">
        SIS Voting System In College Department
      </a>
    </div>

    <!-- Menu Links -->
    <div class="collapse navbar-collapse" id="navbar-collapse-main">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="insertvoter.php"><strong>Add Voters</strong></a></li>
        <li><a href="users.php"><strong>Voters</strong></a></li> 
        <li><a href="feedbackReport.php"><strong>Feedback Report</strong></a></li> 
        <li><a href="login.php" class="btn btn-danger navbar-btn">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>



    <div class="container">
      <div class="row">
        <div class="col-xs-" style="border:px outset gray;">

          <div class="excel-export">
            <button id="exportExcel" class="btn btn-success">Export to Excel</button>
          </div>

          <!-- Position List -->
          <div class="position-list">
            <?php
              require 'config.php';
              $conn = mysqli_connect($hostname, $username, $password, $database);
              if (!$conn) {
                  die("Connection failed: " . mysqli_connect_error());
              }

              $positions = [
                'president' =>      'President', 
                'vice_pres' =>      'Vice President', 
                'secretary' =>      'Secretary', 
                'treasurer' =>      'Treasurer',
                'auditor' =>        'Auditor'
              ];
              
              foreach ($positions as $column => $title) {
                echo "<a href='position.php?position=$column'><strong>$title</strong></a>";
              }
              
              // Fetch overall results
              $overallResults = [];
              foreach ($positions as $column => $title) {
                  $sql = "SELECT $column, COUNT(*) as votes FROM score GROUP BY $column";
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_assoc($result)) {
                      $overallResults[$row[$column]] = $row['votes'];
                  }
              }
              mysqli_close($conn);
            ?>
          </div>

          <!-- Overall Results Section -->
          <div class="overall-results">
            <h3>Overall Voting Results</h3>
            <canvas id="overallChart"></canvas>
            <script>
              const ctx = document.getElementById('overallChart').getContext('2d');
              const overallResults = <?php echo json_encode($overallResults); ?>;
              const labels = Object.keys(overallResults);
              const data = Object.values(overallResults);

              const updateChart = () => {
                new Chart(ctx, {
                  type: 'bar',
                  data: {
                    labels: labels,
                    datasets: [{
                      label: 'Votes',
                      data: data,
                      backgroundColor: 'rgba(54, 162, 235, 0.5)',
                      borderColor: 'rgba(54, 162, 235, 1)',
                      borderWidth: 1
                    }]
                  },
                  options: {
                    responsive: true,
                    scales: {
                      x: {
                        beginAtZero: true,
                        barPercentage: 0.4,
                        categoryPercentage: 0.6,
                      },
                      y: {
                        beginAtZero: true
                      }
                    },
                    plugins: {
                      legend: {
                        position: 'top',
                        labels: {
                          font: {
                            size: 12
                          }
                        }
                      },
                      tooltip: {
                        bodyFont: {
                          size: 10
                        }
                      }
                    }
                  }
                });
              };

              // Initialize chart
              updateChart();

              // Export to Excel
              document.getElementById('exportExcel').addEventListener('click', function() {
                const wb = XLSX.utils.book_new();
                const ws = XLSX.utils.json_to_sheet(Object.entries(overallResults).map(([key, value]) => ({ Position: key, Votes: value })));
                XLSX.utils.book_append_sheet(wb, ws, "Voting Results");
                XLSX.writeFile(wb, "voting_results.xlsx");
              });
            </script>
          </div>

        </div>
      </div>
    </div>
  </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
