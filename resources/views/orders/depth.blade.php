<script src="https://cdn.plot.ly/plotly-3.1.0.min.js" charset="utf-8"></script>
<div id="target"></div>

<script>
    const buy = @json($buy);
    const sell = @json($sell);

    let buy_x = [];
    let buy_y = [];

    let sell_x = [];
    let sell_y = [];

    for ([price, elems] of Object.entries(buy).reverse()) {
        let total = buy_y.at(-1)??0;
        for (i of elems) {
            total += i.amount_remaining;
        }
        buy_x.push(parseFloat(price.replace(/[,c]/g, '')))
        buy_y.push(total)
    }
    for ([price, elems] of Object.entries(sell)) {
        let total = sell_x.at(-1)??0;
        for (i of elems) {
            total += i.amount_remaining;
        }
        sell_x.push(parseFloat(price.replace(/[,c]/g, '')))
        sell_y.push(total)
    }

    let min_buy = buy_x.at(-1) ?? 0;
    let max_sell = sell_x.at(-1) ?? (buy_y.at(0) ?? 0);

    let width = max_sell - min_buy;
    let margin = width / 10;

    if (buy_x.length > 0) {
        buy_x.push(buy_x.at(-1) - margin);
        buy_y.push(buy_y.at(-1));
    }
    if (sell_x.length > 0) {
        sell_x.push(sell_x.at(-1) + margin);
        sell_y.push(sell_y.at(-1));
    }

    var data = [
        // buy
        {
            name: "Buy orders",
            x: buy_x,
            y: buy_y,
            fill: 'tozeroy',
            type: 'scatter',
            line: {
                color: 'green',
                shape: "hv"
            },
            marker: {
                size: 8
            },
            mode: "lines+markers",
            fillcolor: '#00920082',
        },
        // sell
        {
            name: "Sell orders",
            x: sell_x,
            y: sell_y,
            fill: 'tozeroy',
            type: 'scatter',
            line: {
                color: 'red',
                shape: "hv"
            },
            marker: {
                size: 8
            },
            mode: "lines+markers",
            fillcolor: '#92000082',
        },
    ];
    const layout = {
        xaxis: {
            title: {
                text: "Coins"
            }
        },
        yaxis: {
            title: {
                text: "Amount"
            }
        },
    }
    Plotly.newPlot('target', data, layout);
</script>
