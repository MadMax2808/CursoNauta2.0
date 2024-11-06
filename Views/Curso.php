<?php include 'Views\Parciales\Head.php'; ?>
<link rel="stylesheet" href="Views/css/SCurso.css">
<?php include 'Views\Parciales\Nav.php'; ?>

<?php
require_once 'Controllers/CursoController.php';

$cursoController = new CursoController();
$idCurso = 25;

if ($idCurso > 0) {
    $curso = $cursoController->obtenerCursoPorId($idCurso);
    $niveles = $cursoController->obtenerNivelesPorCurso($idCurso);
} else {
    echo "Curso no encontrado.";
    exit;
}
?>

<div class="course-container">

    <div class="course-header" style="background-image: url('data:image/jpeg;base64,<?php echo base64_encode($curso['imagen']); ?>');">
        <h1 class="course-title"><?php echo htmlspecialchars($curso['titulo']); ?></h1>
        <p class="course-category">Categoría: <?php echo htmlspecialchars($curso['nombre_categoria']); ?></p>
        <p class="course-category"><strong>Creador:</strong> <?php echo htmlspecialchars($curso['nombre_creador']); ?></p>
    </div>

    <div class="course-description">
        <p><?php echo htmlspecialchars($curso['descripcion']); ?></p>
    </div>

    <div class="course-content">
        <div class="video-and-topics">
            <div class="video-section">
                <video id="course-video" controls></video>
                <h4>Tu progreso: 50%</h4>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 50%;"></div>
                </div>
            </div>

            <div class="topics-section">
                <div class="topic-title">
                    <i class="fas fa-book"></i>
                    <h2>Niveles</h2>
                </div>
                <ul class="topics-list">
                    <?php foreach ($niveles as $nivel): ?>
                        <li>
                            <button class="topic-btn">
                                <?php echo htmlspecialchars($nivel['titulo_nivel']); ?>
                                <span class="arrow">▶</span>
                            </button>
                            <ul class="subtopics-list">
                                <!-- Enlace al video -->
                                <li>
                                    <input type="checkbox" class="subtopic-checkbox" id="subtopic<?php echo $nivel['id_nivel']; ?>">
                                    <label for="subtopic<?php echo $nivel['id_nivel']; ?>">
                                        <a href="data:video/mp4;base64,<?php echo base64_encode($nivel['video']); ?>" class="subtopic-link">
                                            Ver Video de <?php echo htmlspecialchars($nivel['titulo_nivel']); ?>
                                        </a>
                                    </label>
                                </li>
                                <!-- Visualización del archivo adicional en línea usando solo <object> -->
                                <?php if (!empty($nivel['archivos'])): ?>
                                    <li>
                                        <?php
                                        $finfo = new finfo(FILEINFO_MIME_TYPE);
                                        $mime_type = $finfo->buffer($nivel['archivos']);
                                        ?>
                                        <object data="data:<?php echo $mime_type; ?>;base64,<?php echo base64_encode($nivel['archivos']); ?>"
                                            type="<?php echo $mime_type; ?>" width="100%" height="300px">
                                            <p>Tu navegador no puede mostrar este archivo.</p>
                                        </object>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="course-resources">
            <div class="resource-header">
                <span>Recursos</span>
                <span class="toggle-icon">▶</span>
            </div>
            <div class="resource-content">
                <ul>
                    <?php foreach ($niveles as $nivel): ?>
                        <?php if (!empty($nivel['archivos'])): ?>
                            <?php
                            // Detectar el tipo MIME del archivo y asignar extensión adecuada
                            $finfo = new finfo(FILEINFO_MIME_TYPE);
                            $mime_type = $finfo->buffer($nivel['archivos']);
                            $extension = '';

                            switch ($mime_type) {
                                case 'application/pdf':
                                    $extension = '.pdf';
                                    break;
                                case 'image/jpeg':
                                    $extension = '.jpg';
                                    break;
                                case 'image/png':
                                    $extension = '.png';
                                    break;
                                    // Agregar más casos según el tipo de archivo
                                default:
                                    $extension = '';
                            }
                            ?>
                            <li>
                                <a href="data:<?php echo $mime_type; ?>;base64,<?php echo base64_encode($nivel['archivos']); ?>"
                                    download="Archivo_nivel_<?php echo $nivel['numero_nivel'] . $extension; ?>">
                                    <i class="file-icon">📄</i> Descargar <?php echo htmlspecialchars($nivel['titulo_nivel']); ?> - Nivel <?php echo $nivel['numero_nivel']; ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="feedback-section">
            <h2>Valoraciones</h2>
            <div class="ratings">
                <span class="rating">⭐⭐⭐⭐☆</span> <!-- 4 estrellas de 5 -->
                <span>(20 valoraciones)</span>
            </div>


            <div class="comments">
                <h2>Comentarios</h2>

                <div class="comment">
                    <div class="user-info">
                        <img src="Recursos/Icon.png" alt="Foto del Usuario" class="comment-user-img">
                        <div>
                            <p class="comment-username"> MikeWas</p>
                            <p class="comment-date">12/09/2024, 14:30</p>
                        </div>
                    </div>
                    <p class="comment-text">Buen Curso, tiene lo necesario para empezar a entrar al mundo del diseño
                        web, aunque me gustaria que fuera mas largo</p>
                    <button class="delete-btn">Eliminar</button>
                </div>

                <div class="comment">
                    <div class="user-info">
                        <img src="Recursos/Icon.png" alt="Foto del Usuario" class="comment-user-img">
                        <div>
                            <p class="comment-username"> MikeWas'Nt</p>
                            <p class="comment-date">05/07/2024, 17:30</p>
                        </div>
                    </div>
                    <p class="comment-text">Que feo curso</p>
                    <button class="delete-btn">Eliminar</button>
                </div>


            </div>

        </div>

    </div>

    <div class="course-purchase">
        <h2>Adquiere este curso</h2>
        <p class="course-price"><strong>$<?php echo htmlspecialchars($curso['costo']); ?></strong></p>
        <a href="index.php?page=Pago" class="purchase-btn">Comprar Curso</a>
    </div>

</div>

<script src="Views\js\JCurso.js"> </script>
<?php include 'Views\Parciales\Footer.php'; ?>