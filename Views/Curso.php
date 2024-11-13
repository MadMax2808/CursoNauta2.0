<?php include 'Views\Parciales\Head.php'; ?>
<link rel="stylesheet" href="Views/css/SCurso.css">

<?php include 'Views\Parciales\Nav.php'; ?>

<?php
require_once 'Controllers/CursoController.php';

$cursoController = new CursoController();
$idCurso = isset($_GET['idCurso']) ? intval($_GET['idCurso']) : 0;
$idUsuario = $_SESSION['user_id'] ?? null;

if ($idCurso > 0) {
    $curso = $cursoController->obtenerCursoPorId($idCurso);
    $esGratuito = $curso['costo'] == 0;
    $haComprado = $idUsuario ? $cursoController->verificarCompraCurso($idCurso, $idUsuario) : false;
    $niveles = $cursoController->obtenerNivelesPorCurso($idCurso);
    $valoracionPromedio = $cursoController->obtenerValoracionPromedio($idCurso);
    $comentarios = $cursoController->obtenerComentarios($idCurso);

    // Obtener el progreso actual del usuario
    $progreso = $cursoController->obtenerProgresoCurso($idCurso, $idUsuario); // Obtenemos el progreso actual del usuario

    $nivelesCompletados = floor($progreso / (100 / count($niveles)));
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
        <a href="index.php?page=Mensajes&user_id=<?php echo $curso['id_instructor']; ?>" title="Enviar mensaje al creador" style="margin-left: 5px; font-size: 1.5em;">
            📧
        </a>
    </div>

    <div class="course-description">
        <p><?php echo htmlspecialchars($curso['descripcion']); ?></p>
    </div>

    <div class="course-content">
        <div class="video-and-topics">
            <div class="video-section">

                <!-- Mostrar el video siempre, pero solo habilitar el contenido si el curso fue comprado o es gratuito -->
                <video id="course-video" controls>
                    <source src="data:video/mp4;base64,<?php echo base64_encode($curso['video_principal']); ?>" type="video/mp4">
                    Tu navegador no soporta la reproducción de video.
                </video>

                <!-- Progreso del curso, visible solo si el curso es gratuito o fue comprado -->
                <?php if ($esGratuito || $haComprado): ?>
                    <h4>Tu progreso: <?php echo htmlspecialchars($progreso); ?>%</h4>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?php echo htmlspecialchars($progreso); ?>%;"></div>
                    </div>
                <?php endif; ?>
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
                                <?php if ($esGratuito || $haComprado): ?>
                                    <!-- Mostrar contenido del nivel solo si el curso fue comprado o es gratuito -->
                                    <li>
                                        <label for="subtopic<?php echo $nivel['id_nivel']; ?>">
                                            <a href="data:video/mp4;base64,<?php echo base64_encode($nivel['video']); ?>" class="subtopic-link">
                                                Ver Video de <?php echo htmlspecialchars($nivel['titulo_nivel']); ?>
                                            </a>
                                        </label>
                                    </li>
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
                                <?php else: ?>
                                    <p>Contenido disponible solo para usuarios que hayan adquirido el curso.</p>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <!-- Formulario oculto para enviar el progreso al completar un video -->
        <form id="progresoForm" method="POST">
            <input type="hidden" name="idCurso" value="<?php echo $idCurso; ?>">
            <input type="hidden" name="progreso" id="progreso" value="">
            <input type="hidden" name="action" value="actualizarProgreso">
        </form>

        <div class="course-resources">
            <div class="resource-header">
                <span>Recursos</span>
                <span class="toggle-icon">▶</span>
            </div>
            <div class="resource-content">
                <ul>
                    <?php foreach ($niveles as $nivel): ?>
                        <?php if ($esGratuito || $haComprado): ?>
                            <?php if (!empty($nivel['archivos'])): ?>
                                <?php
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
                        <?php else: ?>
                            <p>Contenido disponible solo para usuarios que hayan adquirido el curso.</p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="feedback-section">
            <h2>Valoraciones</h2>
            <div class="ratings">
                <span class="rating">
                    <?php
                    $estrellas = round($valoracionPromedio);
                    echo str_repeat('⭐', $estrellas) . str_repeat('☆', 5 - $estrellas);
                    ?>
                </span>
                <span>(<?php echo count($comentarios); ?> valoraciones)</span>
            </div>

               <!-- Modal para Eliminar con Motivo -->
            <div id="deleteModal" class="modal">
                <div class="modal-content">
                    <span class="close-btn">&times;</span>
                    <h2>¿Por qué deseas eliminar este comentario?</h2>
                    <textarea id="motivo" placeholder="Escribe tu motivo aquí..."></textarea>
                    <button id="confirmDelete" class="confirm-btn">Confirmar Eliminación</button>
                </div>
            </div>


            <div class="comments">
                <h2>Comentarios</h2>
                <?php foreach ($comentarios as $comentario): ?>
                    <div class="comment">
                        <div class="user-info">
                            <img src="<?php echo htmlspecialchars($comentario['foto_avatar'] ?: 'Recursos/Icon.png'); ?>"
                                alt="Foto del Usuario" class="comment-user-img">
                            <div>
                                <p class="comment-username"><?php echo htmlspecialchars($comentario['nombre_usuario']); ?>
                                </p>
                                <p class="comment-date">
                                    <?php echo htmlspecialchars(date('d/m/Y, H:i', strtotime($comentario['fecha_comentario']))); ?>
                                </p>
                            </div>
                        </div>

                        <!-- Mostrar comentario o mensaje de eliminado -->
                        <?php if ($comentario['eliminado']): ?>
                            <p class="comment-text"><em>(Este comentario ha sido eliminado por el administrador)</em></p>
                            
                        <?php else: ?>
                            <p class="comment-text"><?php echo htmlspecialchars($comentario['comentario']); ?></p>
                        <?php endif; ?>

                        <!-- Botón de Eliminar para administradores -->
                        <?php if ($_SESSION['user_role'] == 1 && !$comentario['eliminado']): ?>
                            <form action="" method="POST" class="delete-comment-form"
                                data-id="<?php echo $comentario['id_comentario']; ?>">
                                <input type="hidden" name="action" value="eliminarComentario">
                                <input type="hidden" name="idComentario" value="<?php echo $comentario['id_comentario']; ?>">
                                <input type="hidden" name="idCurso" value="<?php echo $idCurso; ?>">
                                <button type="button" class="delete-btn"
                                    data-id="<?php echo $comentario['id_comentario']; ?>">Eliminar</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Mostrar el botón de compra solo si el curso no ha sido comprado y no es gratuito -->
    <?php if (!$esGratuito && !$haComprado): ?>
        <div class="course-purchase">
            <h2>Adquiere este curso</h2>
            <p class="course-price"><strong>$<?php echo htmlspecialchars($curso['costo']); ?></strong></p>
            <a href="index.php?page=Pago&idCurso=<?php echo $idCurso; ?>" class="purchase-btn">Comprar Curso</a>
        </div>
    <?php endif; ?>
</div>

<script src="Views/js/JCurso.js"></script>
<?php include 'Views\Parciales\Footer.php'; ?>