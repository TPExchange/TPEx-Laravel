@props(["history"])
<script src="https://cdn.plot.ly/plotly-3.1.0.min.js" charset="utf-8"></script>
<div id="history-plot"></div>

<script>
    {
        let x = [];
        let y = [];
        let best_buy_y = [];
        let best_buy_x = [];
        let best_sell_x = [];
        let best_sell_y = [];

        for (elem of @json($history)) {
            let best_buy = elem.best_buy ? parseFloat(elem.best_buy.replace(/[,c]/g, '')) : null;
            let best_sell = elem.best_sell ? parseFloat(elem.best_sell.replace(/[,c]/g, '')) : null;
            let mid_market = (((best_buy ?? best_sell + 0)) + (best_sell ?? best_buy + 0)) / 2;
            if (mid_market == 0) {
                mid_market = null;
            }
            if (best_buy !== null) {
                console.log(elem);
                best_buy_y.push(best_buy);
                best_buy_x.push(elem.time);
            }
            if (best_sell !== null) {
                best_sell_y.push(best_sell);
                best_sell_x.push(elem.time);
            }
            if (mid_market !== null) {
                y.push(mid_market);
                x.push(elem.time);
            }
        }

        var data = [
            // buy
            {
                name: "Mid-market price",
                x: x,
                y: y,
                type: 'scatter',
                line: {
                    color: 'blue',
                },
                marker: {
                    size: 8
                },
                mode: "lines",
            },

            {
                name: "Best sell price",
                x: best_sell_x,
                y: best_sell_y,
                visible: "legendonly",
                type: 'scatter',
                line: {
                    color: 'red',
                },
                marker: {
                    size: 8
                },
                marker: {
                    size: 8
                },
                mode: "lines+markers",
            },
            {
                name: "Best buy price",
                x: best_buy_x,
                y: best_buy_y,
                visible: "legendonly",
                type: 'scatter',
                line: {
                    color: 'green',
                },
                marker: {
                    size: 8
                },
                marker: {
                    size: 8
                },
                mode: "lines+markers",
            },
        ];
        var layout = {
            xaxis: {
                title: {
                    text: "Time"
                }
            },
            yaxis: {
                title: {
                    text: "Coins"
                },
                rangemode: "tozero"
            },
            showlegend: true
        }
        Plotly.newPlot('history-plot', data, layout);
    }
</script>
