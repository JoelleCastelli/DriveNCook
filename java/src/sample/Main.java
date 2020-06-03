package sample;

import javafx.application.Application;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.BorderPane;
import javafx.stage.Stage;

import java.io.IOException;
import java.sql.*;

import com.mysql.jdbc.Driver;


public class Main extends Application {

    private Stage primaryStage;
    private BorderPane rootLayout;

    private ObservableList<User> userList = FXCollections.observableArrayList();

    @Override
    public void start(Stage primaryStage) throws Exception {
        this.primaryStage = primaryStage;
        this.primaryStage.setTitle("Userlist");


        initRootLayout();

        showUserList();
    }

    public Main() {
        getUserListDB();
    }

    public static void main(String[] args) {

        launch(args);
    }

    public Stage getPrimaryStage() {
        return primaryStage;
    }

    public void initRootLayout() {
        try {
            // Load root layout from fxml file.
            FXMLLoader loader = new FXMLLoader();
            loader.setLocation(Main.class.getResource("RootLayout.fxml"));
            rootLayout = (BorderPane) loader.load();

            // Show the scene containing the root layout.
            Scene scene = new Scene(rootLayout);
            primaryStage.setScene(scene);
            primaryStage.show();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    public void showUserList() {
        try {
            // Load person overview.
            FXMLLoader loader = new FXMLLoader();
            loader.setLocation(Main.class.getResource("Overview.fxml"));

            AnchorPane personOverview = (AnchorPane) loader.load();
            // Set person overview into the center of root layout.
            rootLayout.setCenter(personOverview);

            UserController controller = loader.getController();
            controller.setMainApp(this);
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    public ObservableList<User> getUserList() {
        return userList;
    }

    public void getUserListDB() {
        String url = "jdbc:mysql://134.122.107.73:3306/drivencook";
        String user = "mysql";
        String password = "ESGIgroupe6";
        Connection cn = null;
        Statement st = null;
        ResultSet rs = null;

        try {
            Class.forName("com.mysql.jdbc.Driver");

            cn = DriverManager.getConnection(url, user, password);

            st = cn.createStatement();
            String sql = "SELECT email,firstname,lastname,role FROM user WHERE role = 'client'";

            rs = st.executeQuery(sql);

            while (rs.next()) {
                User userN = new User(
                        rs.getString("email"),
                        rs.getString("firstname"),
                        rs.getString("lastname"),
                        rs.getString("role")
                );
                userList.add(userN);
            }


        } catch (SQLException e) {
            e.printStackTrace();
        } catch (ClassNotFoundException e) {
            e.printStackTrace();
        } finally {
            try {
                cn.close();
                st.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }

    }
}
