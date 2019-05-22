export default class myRequest {
  static get(name) {
    this.url = new URL(window.location);
    return this.url.searchParams.get(name);
  }
}
