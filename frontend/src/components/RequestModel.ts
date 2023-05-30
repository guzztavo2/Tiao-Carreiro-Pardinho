/* eslint-disable no-async-promise-executor */
/* eslint-disable @typescript-eslint/no-explicit-any */
import Storage from "./StorageModel";
import User from "./UserModel";
export default class Request {
  private xhr: XMLHttpRequest;
  public static validation = {
    setValidation: (expireTime: string, validation: string) => {
      Storage.setItem("expireTime", expireTime);
      Storage.setItem("validation", validation);
    },
    getValidation: async () => {
      const code = Storage.getItem("validation");
      const expiration: string | null | Date = Storage.getItem("expireTime");

      if (
        code == null ||
        expiration == null ||
        typeof expiration !== "string" ||
        !(new Date(expiration) > new Date())
      )
        await Request.getValidation();
      return Storage.getItem("validation") as string;
    },
  };
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
    return await new Promise(async (resolve, error) => {
      this.xhr.onloadend = function () {
        if (this.readyState == 4 && this.status == 200) {
          if (isValidation)
            resolve([this.response, this.getResponseHeader("code")]);
          else resolve(this.response);
        } else {
          error(this.response);
        }
      };
      this.xhr.open(method, url);
      if (!isValidation)
        this.xhr.setRequestHeader(
          "code",
          await Request.validation.getValidation()
        );
      if (requestData == undefined) this.xhr.send();
      else this.xhr.send(requestData);
    });
  }
  public async executeAuthenticated(
    method: string,
    url: string,
    requestData: FormData | string | undefined = undefined
  ) {
    return await new Promise(async (resolve, error) => {
      this.xhr.onloadend = function () {
        if (this.readyState == 4 && this.status == 200) resolve(this.response);
        else error(this.response);
      };
      this.xhr.open(method, url);

      this.xhr.setRequestHeader(
        "code",
        await Request.validation.getValidation()
      );

      this.xhr.setRequestHeader(
        "Authorization",
        "Bearer " + User.getToken().token
      );

      if (requestData == undefined) this.xhr.send();
      else this.xhr.send(requestData);
    });
  }
  public static async getValidation() {
    const request = new Request();
    await request
      .Execute("GET", "http://127.0.0.1:8000/api/get-code", undefined, true)
      .then((response: any) => {
        if (response == null) return;
        Request.validation.setValidation(
          JSON.parse(response[0]).expiration,
          response[1]
        );
      });
  }
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  public static transformElementsFormData(
    element: Record<string, any>
  ): FormData {
    const formdata = new FormData();
    for (const el in element) {
      if (typeof element[el] == "string") formdata.set(el, element[el]);
    }
    return formdata;
  }
}
