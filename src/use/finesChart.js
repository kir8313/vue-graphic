import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";
import am4themes_dark from "@amcharts/amcharts4/themes/dark";
import am4lang_ru_RU from "@amcharts/amcharts4/lang/ru_RU";

export default function finesChart(data, chartEl) {
    am4core.useTheme(am4themes_dark);
    am4core.useTheme(am4themes_animated);
    const interfaceColors = new am4core.InterfaceColorSet();
    const chart = am4core.create(chartEl, am4charts.XYChart);
    chart.language.locale = am4lang_ru_RU;
    chart.data = data;
    chart.leftAxesContainer.layout = "vertical";
    chart.colors.step = 3;
    chart.padding(0, 30, 0, 30);
    chart.legend = new am4charts.Legend();
    const dateAxis = chart.xAxes.push(new am4charts.DateAxis());
    dateAxis.renderer.grid.template.location = 0;
    dateAxis.renderer.ticks.template.length = 8;
    dateAxis.renderer.ticks.template.strokeOpacity = 0.1;
    dateAxis.renderer.grid.template.disabled = true;
    dateAxis.renderer.ticks.template.disabled = false;
    dateAxis.renderer.ticks.template.strokeOpacity = 0.2;
    const valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.tooltip.disabled = true;
    valueAxis.zIndex = 1;
    valueAxis.renderer.baseGrid.disabled = true;
    valueAxis.renderer.inside = true;
    valueAxis.height = am4core.percent(50);
    valueAxis.renderer.labels.template.verticalCenter = "bottom";
    valueAxis.renderer.labels.template.padding(2, 2, 2, 2);
    valueAxis.renderer.fontSize = "0.8rem";
    valueAxis.renderer.gridContainer.background.fill = interfaceColors.getFor("alternativeBackground");
    valueAxis.renderer.gridContainer.background.fillOpacity = 0.05;
    const series = chart.series.push(new am4charts.LineSeries());
    series.dataFields.dateX = "date";
    series.dataFields.valueY = "price";
    series.tooltipText = "{valueY.value}";
    series.name = "Сумма";
    const valueAxis2 = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis2.tooltip.disabled = true;
    valueAxis2.marginTop = 30;
    valueAxis2.renderer.baseGrid.disabled = true;
    valueAxis2.renderer.inside = true;
    valueAxis2.height = am4core.percent(50);
    valueAxis2.zIndex = 3;
    valueAxis2.calculateTotals = true;
    valueAxis2.renderer.labels.template.verticalCenter = "bottom";
    valueAxis2.renderer.labels.template.padding(2, 2, 2, 2);
    valueAxis2.renderer.fontSize = "0.8em"
    valueAxis2.renderer.gridContainer.background.fill = interfaceColors.getFor("alternativeBackground");
    valueAxis2.renderer.gridContainer.background.fillOpacity = 0.05;

    function createSeries(value, name, color) {
      const series2 = chart.series.push(new am4charts.ColumnSeries());
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

    createSeries('adm', 'Административные штрафы', '#8067dc');
    createSeries('insignificant', 'Малозначительно', '#dc67ce');
    createSeries('law', 'Прекращено', '#dc6967');
    createSeries('warning', 'Предупреждения', '#459f9c');
    chart.cursor = new am4charts.XYCursor();
    chart.cursor.xAxis = dateAxis;
    const scrollbarX = new am4charts.XYChartScrollbar();
    scrollbarX.series.push(series);
    scrollbarX.marginBottom = 20;
    chart.scrollbarX = scrollbarX;

    return chart;
}