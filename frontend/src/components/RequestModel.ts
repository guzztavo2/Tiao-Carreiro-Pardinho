export default class Request {
  private xhr: XMLHttpRequest;
  private validation = "";
  constructor() {
    this.xhr = new XMLHttpRequest();
    this.xhr.withCredentials = true;
  }
  public async Execute(
    method: string,
    url: string,
    requestData: FormData | string | undefined = undefined,
    isValidation = false
  ) {
    if (this.validation.length == 0 && !isValidation)
      await this.getValidation();

    return await new Promise((resolve, error) => {
      this.xhr.onloadend = function () {
        if (this.readyState == 4 && this.status == 200) {
          if (isValidation) resolve(this.getResponseHeader("code"));
          else resolve(this.response);
        } else {
          error(this.response);
        }
      };
      this.xhr.open(method, url);
      if (this.validation.length !== 0)
        this.xhr.setRequestHeader("code", this.validation);
      if (requestData == undefined) this.xhr.send();
      else this.xhr.send(requestData);
    });
  }
  private async getValidation() {
    const request = new Request();
    await request
      .Execute("GET", "http://127.0.0.1:8000/api/get-code", undefined, true)
      .then((response) => {
        if (typeof response == "string") this.validation = response;
      });
  }
  public static transformElementsFormData(
    element: Record<string, any>
  ): FormData {
    console.log(element);
    const formdata = new FormData();
    for (const el in element) {
      if (typeof element[el] == "string") formdata.set(el, element[el]);
    }
    console.log(formdata);

    return formdata;
  }
}
