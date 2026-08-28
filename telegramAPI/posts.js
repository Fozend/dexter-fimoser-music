(function () {
    const channel = "LiterallyDexter";
 
    const firstPost = 16;
    const postsPerBatch = 10;
 
    // Safety cap: stops us from hammering the server forever if a long run
    // of consecutive posts turns out to be deleted.
    const maxAttemptsPerBatch = 40;
 
    let nextPost = firstPost;
    let loading = false;
 
    const container = document.getElementById("posts-container");
 
    async function checkPostsExist(ids) {
        const url = `telegramAPI/check_post.php?ids=${ids.join(",")}`;
        try {
            const response = await fetch(url);
            if (!response.ok) {
                return {};
            }
            return await response.json();
        } catch (err) {
            console.error("Failed to verify posts:", err);
            return {};
        }
    }
 
    function embedPost(postId) {
        const script = document.createElement("script");
        script.async = true;
        script.src = "https://telegram.org/js/telegram-widget.js?22";
        script.dataset.telegramPost = `${channel}/${postId}`;
        script.dataset.width = "100%";
        container.appendChild(script);
    }
 
    async function loadPosts() {
        if (loading) {
            return;
        }
        loading = true;
 
        let added = 0;
        let attempts = 0;
 
        while (added < postsPerBatch && attempts < maxAttemptsPerBatch) {
            const remaining = postsPerBatch - added;
            const candidateIds = [];
            for (let i = 0; i < remaining; i++) {
                candidateIds.push(nextPost++);
            }
            attempts += candidateIds.length;
 
            const existence = await checkPostsExist(candidateIds);
 
            for (const id of candidateIds) {
                if (existence[id]) {
                    embedPost(id);
                    added++;
                }
            }
        }
 
        loading = false;
    }
 
    container.addEventListener("scroll", () => {
        const distanceToBottom =
            container.scrollHeight - container.scrollTop - container.clientHeight;
 
        if (distanceToBottom < 500) {
            loadPosts();
        }
    });
 
    loadPosts();
})();