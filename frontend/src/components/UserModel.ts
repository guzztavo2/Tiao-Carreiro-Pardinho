import Request from "./RequestModel";
import Storage from "./StorageModel";
export default class User {
  userName!: string;
  userPassword!: string;
  public static userUrl = "http://127.0.0.1:8000/api/user/";
  constructor(
    userName: string | null = null,
    userPassword: string | null = null
  ) {
    if (userName !== null) this.userName = userName;
    if (userPassword !== null) this.userPassword = userPassword;
  }
  static async checkUserName(userName: string) {
    const url = User.userUrl + "check-username";
    const request = new Request();
    const formdata = Request.transformElementsFormData({ name: userName });
    return await request
      .Execute("POST", url, formdata)
      .then((result) => {
        if (typeof result !== "string") return;
        return JSON.parse(result);
      })
      .catch((error) => {
        if (typeof error !== "string") return;
        return JSON.parse(error);
      });
  }
  async registro() {
    const url = User.userUrl + "registro";
    const request = new Request();
    const formData = Request.transformElementsFormData({
      userName: this.userName,
      password: this.userPassword,
    });
    return await request.Execute("POST", url, formData);
  }
  async login() {
    const url = User.userUrl + "login";
    const request = new Request();
    const formData = Request.transformElementsFormData({
      UserName: this.userName,
      Password: this.userPassword,
    });
    return await request.Execute("POST", url, formData);
  }
  public static async logout() {
    const url = User.userUrl + "logout";
    const request = new Request();
    return await request.executeAuthenticated("GET", url);
  }
  static getToken() {
    return {
      token: Storage.getItem("token-access"),
      userName: Storage.getItem("userName"),
    };
  }
  static setToken(token: string, userName: string) {
    Storage.setItem("token-access", token);
    Storage.setItem("userName", userName);
  }
  static cleanToken() {
    Storage.removeItem("token-access");
    Storage.removeItem("userName");
  }
}
