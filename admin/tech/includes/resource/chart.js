$(function () {

  let ctx1 = $('#effieciency-1');

  $(ctx1).chart = new Chart(ctx1, {
    type: 'bar',
    data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  })

  let ctx2 = $('#effieciency-2');
  
  $(ctx2).chart = new Chart(ctx2, {
    type: 'pie',
    data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  })

  $.ajax({
    url: '../includes/class/get_engagement.php',
    method: 'GET',
    success: function (response) {
      const data = JSON.parse(response);

      // Logins Line Chart
      const loginCtx = document.getElementById('loginChart').getContext('2d');
      const loginChart = new Chart(loginCtx, {
        type: 'line',
        data: {
          labels: data.logins.map(item => item.login_day),
          datasets: [{
            label: 'Total Logins',
            data: data.logins.map(item => item.total_logins),
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });

      // Performance Evaluations Pie Chart
      const evaluationCtx = document.getElementById('evaluationChart').getContext('2d');
      const evaluationChart = new Chart(evaluationCtx, {
        type: 'pie',
        data: {
          labels: data.evaluations.map(item => item.evaluation_type),
          datasets: [{
            label: 'Performance Evaluations',
            data: data.evaluations.map(item => item.total_evaluations),
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'top',
            }
          }
        }
      });


    }
  });


});