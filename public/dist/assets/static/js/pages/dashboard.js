window.initDashboard = function () {

  // Early return if no dashboard chart elements exist
  const hasChartElements = document.querySelector("#chart-profile-visit") ||
    document.querySelector("#chart-visitors-profile") ||
    document.querySelector("#chart-europe");

  if (!hasChartElements) {
    console.log('No chart elements found, skipping dashboard initialization');
    return; // Exit early if we're not on dashboard page
  }

  console.log('Initializing dashboard charts...');

  var optionsProfileVisit = {
    annotations: { position: "back" },
    dataLabels: { enabled: false },
    chart: { type: "bar", height: 300 },
    fill: { opacity: 1 },
    plotOptions: {},
    series: [{ name: "sales", data: [9, 20, 30, 20, 10, 20, 30, 20, 10, 20, 30, 20] }],
    colors: "#435ebe",
    xaxis: {
      categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    },
  }

  var optionsVisitorsProfile = {
    series: [70, 30],
    labels: ["Male", "Female"],
    colors: ["#435ebe", "#55c6e8"],
    chart: { type: "donut", width: "100%", height: "350px" },
    legend: { position: "bottom" },
    plotOptions: { pie: { donut: { size: "30%" } } },
  }

  var optionsEurope = {
    series: [{ name: "series1", data: [310, 800, 600, 430, 540, 340, 605, 805, 430, 540, 340, 605] }],
    chart: { height: 80, type: "area", toolbar: { show: false } },
    colors: ["#5350e9"],
    stroke: { width: 2 },
    grid: { show: false },
    dataLabels: { enabled: false },
    xaxis: {
      type: "datetime",
      categories: [
        "2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z",
        "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z",
        "2018-09-19T06:30:00.000Z", "2018-09-19T07:30:00.000Z", "2018-09-19T08:30:00.000Z",
        "2018-09-19T09:30:00.000Z", "2018-09-19T10:30:00.000Z", "2018-09-19T11:30:00.000Z",
      ],
      axisBorder: { show: false },
      axisTicks: { show: false },
      labels: { show: false },
    },
    show: false,
    yaxis: { labels: { show: false } },
    tooltip: { x: { format: "dd/MM/yy HH:mm" } },
  }

  var optionsAmerica = { ...optionsEurope, colors: ["#008b75"] }
  var optionsIndia = { ...optionsEurope, colors: ["#ffc434"] }
  var optionsIndonesia = { ...optionsEurope, colors: ["#dc3545"] }

  // Helper to render chart if element exists
  function renderChart(selector, options) {
    var el = document.querySelector(selector);
    if (el) {
      try {
        el.innerHTML = ""; // Clear previous chart
        var chart = new ApexCharts(el, options);
        chart.render();
      } catch (error) {
        console.error(`Error rendering chart ${selector}:`, error);
      }
    }
  }

  renderChart("#chart-profile-visit", optionsProfileVisit);
  renderChart("#chart-visitors-profile", optionsVisitorsProfile);
  renderChart("#chart-europe", optionsEurope);
  renderChart("#chart-america", optionsAmerica);
  renderChart("#chart-india", optionsIndia);
  renderChart("#chart-indonesia", optionsIndonesia);
}

// Run on load
window.initDashboard();

// Run on navigation
document.addEventListener('livewire:navigated', window.initDashboard);
