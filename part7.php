<head>
  <? require 'blocks/preheader.php';
  require 'blocks/header.php'; ?>
  <link rel="stylesheet" href="/css/calendar.css">
  <script src="/libs/jQuery.v3.1.0.js"></script>
  <script src="/libs/calendar.js"></script>
  <script src="/libs/ru.js"></script>
</head>
<div style="display: flex;">
  <? $url = 'http://knd.admgor.nnov.ru/';
  $title = 'Штрафы'; ?>
  <? require $dir . '/pages/blocks/menu.php'; ?>
  <main style="width:calc(100% - 75px); padding: 1%; margin: 0;" class="workSpace">
    <div style="display:flex;justify-content: space-between;">
      <div style="border-radius: 5px; width:45%;" class="cont_pn_item">
        <div class="card-header2">Всего назначено штрафов на сумму:</div>
        <h5 class="card-title"><span id="allPenalties"></span> руб</h5>
      </div>
      <button onclick="upload(6)" style="border-radius: 5px; width:10%;" class="cont_pn_item" id="7">
        <h3 class="card-title">Неделя</h3>
        <p id="Buttons_sum0" style="font-size: 2em;margin: 0"></p>
      </button>
      <button onclick="upload(30)" style="border-radius: 5px; width:10%;" class="cont_pn_item" id="30">
        <h3 class="card-title">Месяц</h3>
        <p id="Buttons_sum1" style="font-size: 2em;margin: 0"></p>
      </button>
      <button onclick="upload(90)" style="border-radius: 5px; width:10%;" class="cont_pn_item" id="90">
        <h3 class="card-title">Квартал</h3>
        <p id="Buttons_sum2" style="font-size: 2em;margin: 0"></p>
      </button>
      <button onclick="upload(365)" style="border-radius: 5px; width:10%;" class="cont_pn_item" id="365">
        <h3 class="card-title">Год</h3>
        <p id="Buttons_sum3" style="font-size: 2em;margin: 0"></p>
      </button>
      <button onclick="upload(0)" style="border-radius: 5px; width:10%;" class="cont_pn_item" id="ldCa">
        <h3 class="card-title">Период</h3>
      </button>
    </div>
    <div>
      <div class="cont_pn" style="margin: 0;">
        <div class="cont_pn_item" style="background: #8067dc;">
          <div class="card-header2" style="color: white;">Административные штрафы</div>
          <h5 class="card-title" id="sum1" style="color: white;"></h5>
        </div>
        <div class="cont_pn_item" style="background: #dc67ce;">
          <div class="card-header2" style="color: white;">Малозначительно</div>
          <h5 class="card-title" id="sum2" style="color: white;"></h5>
        </div>
        <div class="cont_pn_item" style="background: #dc6967;">
          <div class="card-header2" style="color: white;">Прекращено</div>
          <h5 class="card-title" id="sum3" style="color: white;"></h5>
        </div>
        <div class="cont_pn_item" style="background: #459f9c;">
          <div class="card-header2" style="color: white;">Предупреждения</div>
          <h5 class="card-title" id="sum4" style="color: white;"></h5>
        </div>
      </div>
    </div>
    <div id="Calendar">
      <div class="calendar"></div>
    </div>
    <div id="chartdiv2" style="width:100%;" class="cont_pn_item"></div>
  </main>
</div>
<? require $dir . '/pages/blocks/footer.php';  ?>
</body>

</html>
<script>
  upload(30)
  buttons()

  function upload(days) {
    console.log('upload penalties data by ' + days + ' days')
    var ld7 = document.getElementById('7'),
      ld30 = document.getElementById('30'),
      ld90 = document.getElementById('90'),
      ld365 = document.getElementById('365'),
      ldCa = document.getElementById('ldCa')
    if (days == 6) {
      ld7.className = "cont_pn_item On";
      ld30.className = "cont_pn_item Off";
      ld90.className = "cont_pn_item Off";
      ld365.className = "cont_pn_item Off";
      ldCa.className = "cont_pn_item Off";
      document.getElementById('Calendar').style.display = 'none';
      loadData(days)
    }
    if (days == 30) {
      ld7.className = "cont_pn_item Off";
      ld30.className = "cont_pn_item On";
      ld90.className = "cont_pn_item Off";
      ld365.className = "cont_pn_item Off";
      ldCa.className = "cont_pn_item Off";
      document.getElementById('Calendar').style.display = 'none';
      loadData(days)
    }
    if (days == 90) {
      ld7.className = "cont_pn_item Off";
      ld30.className = "cont_pn_item Off";
      ld90.className = "cont_pn_item On";
      ld365.className = "cont_pn_item Off";
      ldCa.className = "cont_pn_item Off";
      document.getElementById('Calendar').style.display = 'none';
      loadData(days)
    }
    if (days == 365) {
      ld7.className = "cont_pn_item Off";
      ld30.className = "cont_pn_item Off";
      ld90.className = "cont_pn_item Off";
      ld365.className = "cont_pn_item On";
      ldCa.className = "cont_pn_item Off";
      document.getElementById('Calendar').style.display = 'none';
      loadData(days)
    }
    if (days == 0) {
      if (document.getElementById('Calendar').style.display == '') {
        document.getElementById('Calendar').style.display = 'none';
      } else {
        ld7.className = "cont_pn_item Off";
        ld30.className = "cont_pn_item Off";
        ld90.className = "cont_pn_item Off";
        ld365.className = "cont_pn_item Off";
        ldCa.className = "cont_pn_item On";
        document.getElementById('Calendar').style.display = '';
      }
    }

  }

  function GCD(data) {
    var i = 0,
      chartData = [],
      sum = 0,
      all = 0
    while (data[i]) {
      chartData.push({
        date: data[i]['date'],
        price: data[i]['all'],
        adm: data[i]['adm'],
        warning: data[i]['warning'],
        law: data[i]['law'],
        insignificant: data[i]['insignificant'],
      });
      if (data[i]['all']) sum += data[i]['all']
      i++
    }
    all = document.getElementById('allPenalties')
    all.innerHTML = sum.toLocaleString()
    // console.log(chartData)
    return chartData;
  }

  function chart2(data) {
    am4core.useTheme(am4themes_dark);
    am4core.useTheme(am4themes_animated);
    var interfaceColors = new am4core.InterfaceColorSet();
    var data = data
    var chart = am4core.create("chartdiv2", am4charts.XYChart);
    chart.data = data;
    chart.leftAxesContainer.layout = "vertical";
    chart.colors.step = 3;
    chart.padding(0, 30, 0, 30);
    chart.legend = new am4charts.Legend();
    var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
    dateAxis.renderer.grid.template.location = 0;
    dateAxis.renderer.ticks.template.length = 8;
    dateAxis.renderer.ticks.template.strokeOpacity = 0.1;
    dateAxis.renderer.grid.template.disabled = true;
    dateAxis.renderer.ticks.template.disabled = false;
    dateAxis.renderer.ticks.template.strokeOpacity = 0.2;
    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.tooltip.disabled = true;
    valueAxis.zIndex = 1;
    valueAxis.renderer.baseGrid.disabled = true;
    valueAxis.renderer.inside = true;
    valueAxis.height = am4core.percent(50);
    valueAxis.renderer.labels.template.verticalCenter = "bottom";
    valueAxis.renderer.labels.template.padding(2, 2, 2, 2);
    valueAxis.renderer.fontSize = "0.8em"
    valueAxis.renderer.gridContainer.background.fill = interfaceColors.getFor("alternativeBackground");
    valueAxis.renderer.gridContainer.background.fillOpacity = 0.05;
    var series = chart.series.push(new am4charts.LineSeries());
    series.dataFields.dateX = "date";
    series.dataFields.valueY = "price";
    series.tooltipText = "{valueY.value}";
    series.name = "Сумма";
    var valueAxis2 = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis2.tooltip.disabled = true;
    valueAxis2.marginTop = 30;
    valueAxis2.renderer.baseGrid.disabled = true;
    valueAxis2.renderer.inside = true;
    valueAxis2.height = am4core.percent(50);
    valueAxis2.zIndex = 3
    valueAxis2.calculateTotals = true;
    valueAxis2.renderer.labels.template.verticalCenter = "bottom";
    valueAxis2.renderer.labels.template.padding(2, 2, 2, 2);
    valueAxis2.renderer.fontSize = "0.8em"
    valueAxis2.renderer.gridContainer.background.fill = interfaceColors.getFor("alternativeBackground");
    valueAxis2.renderer.gridContainer.background.fillOpacity = 0.05;

    function createSeries(value, name, color) {
      var series2 = chart.series.push(new am4charts.ColumnSeries());
      series2.columns.template.width = am4core.percent(50);
      series2.dataFields.dateX = "date";
      series2.dataFields.valueY = value;
      series2.yAxis = valueAxis2;
      series2.stacked = true;
      series2.fill = am4core.color(color);
      series2.stroke = am4core.color(color);
      series2.tooltipText = "{valueY.value}";
      series2.name = name;
    }
    createSeries('adm', 'Административные штрафы','#8067dc')
    createSeries('insignificant', 'Малозначительно','#dc67ce')
    createSeries('law', 'Прекращено','#dc6967')
    createSeries('warning', 'Предупреждения','#459f9c')
    chart.cursor = new am4charts.XYCursor();
    chart.cursor.xAxis = dateAxis;
    var scrollbarX = new am4charts.XYChartScrollbar();
    scrollbarX.series.push(series);
    scrollbarX.marginBottom = 20;
    chart.scrollbarX = scrollbarX;
  }

  function loadData(days) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/cron/part7/buttons/' + days + '.txt', false);
    xhr.setRequestHeader('Cache-Control', 'no-cache');
    xhr.send();
    if (xhr.status != 200) console.log('Ошибка ' + xhr.status + ': ' + xhr.statusText);
    else {
      let raw = xhr.responseText
      var data = JSON.parse(raw)
      console.log(data)
      chart2(GCD(data))
      sum(GCD(data))
    }
  }

  function sum(chartData) {
    var adm = 0,
      insignificant = 0,
      law = 0,
      Vnull = 0,
      warning = 0;
    mas = [];
    for (q = 0; q < chartData.length; q++) {
      adm += chartData[q].adm
      insignificant += chartData[q].insignificant
      law += chartData[q].law
      Vnull += chartData[q].null
      warning += chartData[q].warning
    }
    document.getElementById('sum1').innerHTML = adm;
    document.getElementById('sum2').innerHTML = insignificant;
    document.getElementById('sum3').innerHTML = law;
    document.getElementById('sum4').innerHTML = warning;
  }

  $('.calendar').flatpickr({
    inline: true,
    mode: 'range',
    dateFormat: "d.m.Y",
    defaultDate: ["today", "today"],
    locale: "ru",
    firstDayOfWeek: 1,
    onChange: function(selectedDates, dateStr, instance) {
      calendarRangeDays(selectedDates, instance);
    },
    onReady: function(selectedDates, dateStr, instance) {
      calendarRangeDays(selectedDates, instance);
    },
  });

  function getDate(date1, date2) {
    masDate = [];
    var start = new Date(date1);
    var end = new Date(date2);
    while (start <= end) {
      var mm = ((start.getMonth() + 1) >= 10) ? (start.getMonth() + 1) : '0' + (start.getMonth() + 1);
      var dd = ((start.getDate()) >= 10) ? (start.getDate()) : '0' + (start.getDate());
      var yyyy = start.getFullYear();
      var date = yyyy + "-" + mm + "-" + dd;
      masDate.push(date);
      start = new Date(start.setDate(start.getDate() + 1)); //date increase by 1
    }
    return masDate
  }

  function convert(str) {
    var date = new Date(str),
      mnth = ("0" + (date.getMonth() + 1)).slice(-2),
      day = ("0" + date.getDate()).slice(-2);
    return day + '.' + mnth + '.' + date.getFullYear()
  }

  function calendarRangeDays(selectedDates, instance) {
    var today = new Date
    var $parent = $(instance.element).parent('.calendar');
    var date1 = new Date(selectedDates[0]);
    var date2 = new Date(selectedDates[1]);
    var timeDiff = Math.abs(date2.getTime() - date1.getTime());
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
    if (document.getElementById('Calendar').style.display == 'none') {

    } else {
      if (date1 != "Invalid Date" && date2 != "Invalid Date") {
        var mas = [];
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/cron/part7/buttons/365.txt', false);
        xhr.setRequestHeader('Cache-Control', 'no-cache');
        xhr.send();
        if (xhr.status != 200) console.log('Ошибка ' + xhr.status + ': ' + xhr.statusText);
        else {
          let raw = xhr.responseText
          var data = JSON.parse(raw)
          if (convert(date1) > convert(today) && convert(date2) > convert(today)) {
            var mas_data = getDate(today, today)
          } else {
            mas_data = getDate(date1, date2)
          }
          for (w = 0; w < mas_data.length; w++) {
            for (q = 0; q < Object.keys(data).length; q++) {
              if (data[q] == null) {
                q++
              }
              if (data[q].date == mas_data[w]) {
                mas.push(
                  data[q]
                )
              }
            }
            chart2(GCD(mas))
            sum(GCD(mas))
            document.getElementById('Calendar').style.display = 'none';
          }
        }
      }
    }
  }

  function buttons() {
    var sum = 0
    var i = 0
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/cron/part7/buttons/365.txt', false);
    xhr.setRequestHeader('Cache-Control', 'no-cache');
    xhr.send();
    if (xhr.status != 200) console.log('Ошибка ' + xhr.status + ': ' + xhr.statusText);
    else {
      let raw = xhr.responseText
      var data = JSON.parse(raw)
      console.log(data)
    }
    for (e = 0; e < 4; e++) {
      var all = data.length;
      var masdata = [7, 31, 91, all];
      i = data.length - masdata[e];
      console.log(i)
      while (data[i]) {
        sum += data[i].adm + data[i].insignificant + data[i].law + data[i].warning
        i++
      }
      console.log(sum)
      document.getElementById("Buttons_sum" + e).innerHTML = sum
      sum = 0
    }
  }
</script>
<style>
  #chartdiv2 {
    height: 520px;
  }

  .card-title {
    text-align: center;
  }

  h5 {
    margin: 0;
    font-size: 2em;
    color: #607d8b;
  }

  .cont_pn_item {
    width: 24%
  }

  .on {
    background-color: #67B7DC;
    color: #1C1C24;
  }

  .off {
    background-color: #1C1C24;
    color: #8F97AB;
  }

  button {
    background-color: rgba(0, 0, 0, 0);
    border: none;
    color: white;
  }

  .off:hover {
    background-color: #67B7DC;
    box-shadow: 0 4px 8px 0 #67B7DC;
    transition: .6s;
    color: white;
  }

  .calendar__mark:before {
    content: '';
    width: 15px;
    height: 5px;
    position: absolute;
    left: 0;
    top: 50%;
  }

  .calendar__days {
    padding: 15px 0;
  }

  .btn_primary {
    margin-right: 2%;
    background-color: #67B7DC;
    color: #1C1C24;
    box-shadow: 0 4px 8px 0 #67B7DC;
    transition: .5s;
  }

  .flatpickr-day.selected,
  .flatpickr-day.startRange,
  .flatpickr-day.endRange {
    background-color: #67B7DC;
    color: #1C1C24;
    box-shadow: 0 4px 8px 0 #67B7DC;
  }

  .flatpickr-day.startRange:hover,
  .flatpickr-day.endRange:hover,
  .flatpickr-day.selected:focus,
  .flatpickr-day.selected:hover {
    background-color: #67B7DC;
    color: white;
    box-shadow: 0 8px 14px 0 #67B7DC;
    transition: .5s;
  }

  .flatpickr-calendar.inline {
    max-height: 310px;
    background-color: #1C1C24;
    color: white;
    margin-left: 79.5%;
    margin-top: 8%;
    position: absolute;
    z-index: 100;
  }

  .flatpickr-months .flatpickr-prev-month,
  .flatpickr-months .flatpickr-next-month,
  .flatpickr-current-month,
  span.flatpickr-weekday {
    fill: white;
    color: white;
  }

  .flatpickr-day.prevMonthDay,
  .flatpickr-day.nextMonthDay {
    color: #B3B6BD;
  }

  .flatpickr-day {
    color: #88ceff;
  }

  .flatpickr-day.inRange,
  .flatpickr-day.prevMonthDay.inRange,
  .flatpickr-day.nextMonthDay.inRange,
  .flatpickr-day.today.inRange,
  .flatpickr-day.prevMonthDay.today.inRange,
  .flatpickr-day.nextMonthDay.today.inRange,
  .flatpickr-day:hover,
  .flatpickr-day.prevMonthDay:hover,
  .flatpickr-day.nextMonthDay:hover,
  .flatpickr-day:focus,
  .flatpickr-day.prevMonthDay:focus,
  .flatpickr-day.nextMonthDay:focus {
    background-color: #8067dc;
    border-color: #8067dc;
    transition: .5s;
  }

  .flatpickr-current-month .flatpickr-monthDropdown-months .flatpickr-monthDropdown-month {
    background-color: #1c1c24;
    outline: none;
    padding: 0;
  }
</style>