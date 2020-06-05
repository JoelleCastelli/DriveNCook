package javafx;

import javafx.application.Application;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.BorderPane;
import javafx.stage.Stage;

import java.io.IOException;
import java.sql.*;

public class MainApp extends Application {

    private Stage primaryStage;
    private BorderPane rootLayout;

    public javafx.DataBaseDAO dataBaseDAO;
    private ObservableList<javafx.User> userList = FXCollections.observableArrayList();
    private ObservableList<javafx.Promotion> promotionList = FXCollections.observableArrayList();


    @Override
    public void start(Stage stage) throws Exception {
        this.primaryStage = stage;
        primaryStage.setResizable(false);
        primaryStage.setTitle("User Login");

        dataBaseDAO = new javafx.DataBaseDAO();

        initRootLayout();

        showLoginView();
    }

    public static void main(String[] args) {

        launch(args);
    }

    public void initRootLayout() {
        try {
            FXMLLoader loader = new FXMLLoader();
            loader.setLocation(getClass().getResource("/root.fxml"));
            rootLayout = (BorderPane) loader.load();

            // Show the scene containing the root layout.
            Scene scene = new Scene(rootLayout);
            primaryStage.setScene(scene);
            primaryStage.show();
        } catch (IOException e) {
            e.printStackTrace();
        }

    }

    public void showLoginView() {
        try {
            FXMLLoader loader = new FXMLLoader();
            loader.setLocation(getClass().getResource("/login.fxml"));

            AnchorPane loginOverview = (AnchorPane) loader.load();
            rootLayout.setCenter(loginOverview);

            javafx.LoginController loginController = loader.getController();
            loginController.setMainApp(this);
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    public void showUserListView(User loginUser) {

        userList.addAll(dataBaseDAO.getUserListDB());

        try {
            // Load person overview.
            FXMLLoader loader = new FXMLLoader();
            loader.setLocation(getClass().getResource("/UserList.fxml"));

            AnchorPane personOverview = (AnchorPane) loader.load();
            // Set person overview into the center of root layout.
            rootLayout.setCenter(personOverview);

            javafx.UserListController controller = loader.getController();
            controller.setLoginUser(loginUser);
            controller.setMainApp(this);
        } catch (IOException e) {
            e.printStackTrace();
        }
    }


    public ObservableList<javafx.User> getUserList() {
        return userList;
    }

    public void fillPromotionList(String user_id) {
        promotionList.clear();
        promotionList.addAll(dataBaseDAO.getUserPromotionsDB(user_id));
    }

    public ObservableList<Promotion> getPromotionList() {
        return promotionList;
    }
}
