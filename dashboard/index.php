<?php
$basePath = realpath(__DIR__ . "/..");
$baseUrl = "http://localhost";

$proyectos = array_filter(glob($basePath . '/*'), function ($dir) {
    return is_dir($dir) && basename($dir) !== 'dashboard';
});
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Projects · Dashboard - Moisés</title>

    <!-- Bulma -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* ===== RESET BASE ===== */
        html,
        body {
            min-height: 100%;
            background-color: #0d1117;
            color: #c9d1d9;
        }

        /* ===== NAVBAR (GitHub style) ===== */
        .navbar {
            background-color: #010409;
            border-bottom: 1px solid #21262d;
        }

        .navbar-item {
            color: #c9d1d9;
            font-weight: 600;
        }

        /* ===== SECTION DINÁMICA ===== */
        .section {
            min-height: calc(100vh - 4.5rem);
            /* altura real menos navbar */
            padding-top: 4.5rem;
            padding-bottom: 2rem;
        }

        /* ===== HEADER STICKY ===== */
        .header {
            position: sticky;
            top: 4.5rem;
            /* debajo de la navbar */
            background-color: #0d1117;
            z-index: 10;
            padding-bottom: 16px;
            border-bottom: 1px solid #21262d;
        }

        /* ===== SEARCH INPUT ===== */
        .search-input {
            background-color: #010409;
            border: 1px solid #30363d;
            color: #c9d1d9;
        }

        .search-input::placeholder {
            color: #8b949e;
        }

        /* ===== REPO CARDS ===== */
        .repo-card {
            border-bottom: 1px solid #21262d;
            padding: 16px 0;
        }

        .repo-title {
            color: #58a6ff;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .repo-title:hover {
            text-decoration: underline;
        }

        .repo-meta {
            font-size: 0.8rem;
            color: #8b949e;
        }

        /* ===== OPEN BUTTON ===== */
        .open-btn {
            background-color: #238636;
            border: none;
            color: #ffffff;
            font-weight: 600;
        }

        .open-btn:hover {
            background-color: #2ea043;
        }
    </style>
</head>

<body>
    <form method="post" class="mb-4">
        <button class="button is-success is-small">
            <i class="fas fa-play mr-1"></i>
            Start XAMPP
        </button>
        <input type="hidden" name="start_xampp">
    </form>

    <!-- Navbar -->
    <nav class="navbar is-fixed-top">
        <div class="navbar-brand">
            <div class="navbar-item">
                <i class="fab fa-github mr-2"></i>XAMPP Local Projects - Moisés
            </div>
        </div>
    </nav>

    <section class="section" style="padding-top:4.5rem;">
        <div class="container is-max-desktop">

            <!-- Header -->
            <div class="header mb-4">
                <h1 class="title has-text-white is-4 mb-2">
                    Repositories
                </h1>

                <div class="field">
                    <div class="control has-icons-left">
                        <input
                            id="searchInput"
                            class="input search-input"
                            type="text"
                            placeholder="Find a repository…">
                        <span class="icon is-left">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </div>
            </div>

            <!-- List -->
            <div id="projectsContainer">
                <?php foreach ($proyectos as $proyecto):
                    $nombre = basename($proyecto);
                    $url = $baseUrl . '/' . $nombre;
                ?>
                    <div class="repo-card project-card" data-name="<?= strtolower($nombre) ?>">
                        <div class="columns is-vcentered">
                            <div class="column">
                                <a href="<?= $url ?>" target="_blank" class="repo-title">
                                    <?= $nombre ?>
                                </a>
                                <div class="repo-meta mt-1">
                                    <?= $proyecto ?>
                                </div>
                            </div>

                            <div class="column is-narrow">
                                <a href="<?= $url ?>" target="_blank" class="button open-btn is-small">
                                    Open
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <script>
        const searchInput = document.getElementById('searchInput');
        const cards = document.querySelectorAll('.project-card');

        searchInput.addEventListener('input', () => {
            const value = searchInput.value.toLowerCase();

            cards.forEach(card => {
                const name = card.getAttribute('data-name');
                card.style.display = name.includes(value) ? '' : 'none';

                const projectsContainer = document.getElementById('projectsContainer');
                const anyVisible = Array.from(cards).some(c => c.style.display !== 'none');

                if (!anyVisible) {
                    if (!document.getElementById('noResults')) {
                        const noResults = document.createElement('div');
                        noResults.id = 'noResults';
                        noResults.className = 'has-text-centered has-text-grey mt-4';
                        noResults.innerText = 'No projects found.';
                        projectsContainer.appendChild(noResults);
                    }
                } else {
                    const noResults = document.getElementById('noResults');
                    if (noResults) {
                        noResults.remove();
                    }
                }
            });
        });
    </script>

</body>

</html>