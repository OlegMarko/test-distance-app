<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">

                <a href="{{url('/upload-file')}}">Upload routes</a>

                <div class="title m-b-md">
                    <select id="start-route">
                        <option value="start">start</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="finish">finish</option>
                    </select>

                    <select id="end-route">
                        <option value="start">start</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="finish">finish</option>
                    </select>

                    <div id="result"></div>


                    <script>
                        (function() {
                            const startNode = document.getElementById('start-route');
                            const endNode = document.getElementById('end-route');
                            const result = document.getElementById('result');
                            let graph = {};

                            startNode.addEventListener('change', function() {
                                console.log(this.value);
                            });

                            endNode.addEventListener('change', function() {
                                const shortRoute = findShortestPath(graph, startNode.value, this.value);
                                const gratesRoute = findGratesPath(graph, startNode.value, this.value);
                                result.innerHTML = ``;

                                let routes = document.createElement('select');
                                routes.id = "route-alternatives";
                                let option = document.createElement("option");
                                option.value = shortRoute.path.join(',');
                                option.text = `${shortRoute.path.join(', ')} (distance: ${shortRoute.distance})`;
                                routes.appendChild(option);
                                option = document.createElement("option");
                                option.value = gratesRoute.path.join(',');
                                option.text = `${gratesRoute.path.join(', ')} (distance: ${gratesRoute.distance})`;
                                routes.appendChild(option);

                                result.appendChild(routes);
                            });

                            const shortestDistanceNode = (distances, visited) => {
                                let shortest = null;

                                for (let node in distances) {
                                    let currentIsShortest =
                                        shortest === null || distances[node] < distances[shortest];
                                    if (currentIsShortest && !visited.includes(node)) {
                                        shortest = node;
                                    }
                                }
                                return shortest;
                            };
                            const findShortestPath = (graph, startNode, endNode) => {
                                let distances = {};
                                distances[endNode] = "Infinity";
                                distances = Object.assign(distances, graph[startNode]);

                                let parents = { endNode: null };
                                for (let child in graph[startNode]) {
                                    parents[child] = startNode;
                                }

                                let visited = [];
                                let node = shortestDistanceNode(distances, visited);
                                while (node) {
                                    let distance = distances[node];
                                    let children = graph[node];
                                    for (let child in children) {
                                        if (String(child) === String(startNode)) {
                                            continue;
                                        } else {
                                            let newdistance = distance + children[child];
                                            if (!distances[child] || distances[child] > newdistance) {
                                                distances[child] = newdistance;
                                                parents[child] = node;
                                            }
                                        }
                                    }
                                    visited.push(node);
                                    node = shortestDistanceNode(distances, visited);
                                }

                                let shortestPath = [endNode];
                                let parent = parents[endNode];
                                while (parent) {
                                    shortestPath.push(parent);
                                    parent = parents[parent];
                                }
                                shortestPath.reverse();

                                let results = {
                                    distance: distances[endNode],
                                    path: shortestPath,
                                };

                                return results;
                            };

                            const gratesDistanceNode = (distances, visited) => {
                                let shortest = null;

                                for (let node in distances) {
                                    let currentIsShortest =
                                        shortest === null || distances[node] > distances[shortest];
                                    if (currentIsShortest && !visited.includes(node)) {
                                        shortest = node;
                                    }
                                }
                                return shortest;
                            };
                            const findGratesPath = (graph, startNode, endNode) => {
                                let distances = {};
                                distances[endNode] = "Infinity";
                                distances = Object.assign(distances, graph[startNode]);

                                let parents = { endNode: null };
                                for (let child in graph[startNode]) {
                                    parents[child] = startNode;
                                }

                                let visited = [];
                                let node = gratesDistanceNode(distances, visited);
                                while (node) {
                                    let distance = distances[node];
                                    let children = graph[node];
                                    for (let child in children) {
                                        if (String(child) === String(startNode)) {
                                            continue;
                                        } else {
                                            let newdistance = distance + children[child];
                                            if (!distances[child] || distances[child] < newdistance) {
                                                distances[child] = newdistance;
                                                parents[child] = node;
                                            }
                                        }
                                    }
                                    visited.push(node);
                                    node = gratesDistanceNode(distances, visited);
                                }

                                let shortestPath = [endNode];
                                let parent = parents[endNode];
                                while (parent) {
                                    shortestPath.push(parent);
                                    parent = parents[parent];
                                }
                                shortestPath.reverse();

                                let results = {
                                    distance: distances[endNode],
                                    path: shortestPath,
                                };

                                return results;
                            };

                            fetch('/route/graph', {
                                method: "GET", headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                            })
                            .then((response) => {
                                return response.json().then((data) => {
                                    return graph = data;
                                }).catch((err) => {
                                    console.log(err);
                                })
                            });
                        })();
                    </script>
                </div>
            </div>
        </div>
    </body>
</html>
