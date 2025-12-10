

    <footer class="mt-32 border-t border-zinc-200 dark:border-zinc-800 pb-16 pt-10 text-center text-sm text-zinc-500">
        <?php wp_footer();?>
        <p>© 2025 Arash Fadaee All rights reserved.</p>
    </footer>

</div>

<!-- Optimized Dark Mode -->
<script>
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const saved = localStorage.theme;
    if (saved === 'dark' || (!saved && prefersDark)) document.documentElement.classList.add('dark');
    else document.documentElement.classList.remove('dark');
</script>
</body>
</html>