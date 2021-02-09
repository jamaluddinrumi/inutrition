function getTitle(vm) {
    let { title } = vm.$options;
    if (title) {
        return typeof title === "function" ? title.call(vm) : title;
    }
}
export default {
    created() {
        let title = getTitle(this);
        if (title) {
            document.title = title;
        }
    }
};
