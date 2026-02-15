
<!-- Footer -->
<footer class="bg-light text-center text-muted py-4 mt-5 border-top">
    <div class="container">
        &copy; {{ date('Y') }} MySocial. All rights reserved.
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleEdit(id) {
    let form = document.getElementById('edit-form-' + id);
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
</script>

</body>
</html>
