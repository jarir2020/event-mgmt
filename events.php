<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Event List</h1>
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" id="filter" class="form-control" placeholder="Search by Event Name">
            </div>
            <div class="col-md-4">
                <select id="sortOrder" class="form-control">
                    <option value="asc">Sort: Ascending</option>
                    <option value="desc">Sort: Descending</option>
                </select>
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary w-100" id="loadEvents">Load Events</button>
            </div>
        </div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th id="sortEventName" style="cursor: pointer;">Event Name</th>
                    <th>Event Description</th>
                    <th>Event Time</th>
                    <th>Host</th>
                </tr>
            </thead>
            <tbody id="eventTableBody">
                <tr>
                    <td colspan="5" class="text-center">No events found.</td>
                </tr>
            </tbody>
        </table>
        <nav>
            <ul class="pagination justify-content-center" id="pagination">
                <!-- Pagination buttons will be dynamically generated here -->
            </ul>
        </nav>
    </div>
    <script>
        const apiUrl = 'event_fetch_api.php';
        let currentPage = 1;
        const itemsPerPage = 5;
        let events = [];
        let sortOrder = 'asc';

        // Fetch events from the API
        async function fetchEvents() {
            try {
                const filter = document.getElementById('filter').value;
                const response = await axios.get(apiUrl);
                if (response.status === 200) {
                    events = response.data.data.filter(event => 
                        event.EventName.toLowerCase().includes(filter.toLowerCase())
                    );
                    renderTable();
                } else {
                    Swal.fire('No Events Found', '', 'info');
                }
            } catch (error) {
                Swal.fire('Error fetching events', error.message, 'error');
            }
        }

        // Render the table with events
        function renderTable() {
            const tableBody = document.getElementById('eventTableBody');
            tableBody.innerHTML = '';

            // Sort events
            events.sort((a, b) => {
                const nameA = a.EventName.toLowerCase();
                const nameB = b.EventName.toLowerCase();
                return sortOrder === 'asc' ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
            });

            // Paginate events
            const start = (currentPage - 1) * itemsPerPage;
            const paginatedEvents = events.slice(start, start + itemsPerPage);

            // Populate rows
            paginatedEvents.forEach((event, index) => {
                const row = `
                    <tr>
                        <td>${start + index + 1}</td>
                        <td>${event.EventName}</td>
                        <td>${event.EventDescription}</td>
                        <td>${event.EventTime}</td>
                        <td>${event.Host}</td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', row);
            });

            // If no events in the table, show a message
            if (paginatedEvents.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="5" class="text-center">No events found.</td></tr>';
            }

            renderPagination();
        }

        // Render pagination controls
        function renderPagination() {
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';

            const totalPages = Math.ceil(events.length / itemsPerPage);
            for (let i = 1; i <= totalPages; i++) {
                const pageItem = `
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="javascript:void(0);" onclick="changePage(${i})">${i}</a>
                    </li>
                `;
                pagination.insertAdjacentHTML('beforeend', pageItem);
            }
        }

        // Change current page and reload the table
        function changePage(page) {
            currentPage = page;
            renderTable();
        }

        // Initialize event listeners
        document.getElementById('loadEvents').addEventListener('click', fetchEvents);
        document.getElementById('sortOrder').addEventListener('change', function () {
            sortOrder = this.value;
            renderTable();
        });

        // Initial load
        fetchEvents();
    </script>
    <div style="display: flex; gap: 3px; justify-content: center; align-items: center; margin-top: 20px;">
    <center><button class="btn btn-primary w-10"><a href="index.php" style="color:white; text-decoration:none;">Back to Login</button></center>
    <center><button class="btn btn-primary w-10"><a href="event_reg.php" style="color:white; text-decoration:none;">Event Registration</button></center>
    </div>
</body>
</html>
