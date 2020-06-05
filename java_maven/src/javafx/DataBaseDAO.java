package javafx;

import org.apache.commons.codec.digest.DigestUtils;

import java.nio.charset.StandardCharsets;
import java.sql.*;
import java.util.ArrayList;

public class DataBaseDAO {
    private String url = "jdbc:mysql://134.122.107.73:3306/drivencook";
    private String user = "mysql";
    private String db_password = "ESGIgroupe6";
    private Connection cn = null;
    private PreparedStatement ps = null;
    private Statement st = null;
    private ResultSet rs = null;


    public ArrayList<javafx.User> getUserListDB() {
        ArrayList<javafx.User> userList = new ArrayList<javafx.User>();

        try {
            Class.forName("com.mysql.cj.jdbc.Driver");

            cn = DriverManager.getConnection(url, user, db_password);

            st = cn.createStatement();

            String sql = "SELECT email,firstname,lastname,role FROM user WHERE role = 'client'";

            rs = st.executeQuery(sql);

            while (rs.next()) {
                javafx.User userN = new javafx.User(
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
        return userList;
    }

    public User Login(String email, String password) {
        String hashed_password = DigestUtils.sha256Hex(password);

        try {
            Class.forName("com.mysql.cj.jdbc.Driver");

            cn = DriverManager.getConnection(url, user, db_password);

            String sql = "SELECT email,firstname,lastname,role FROM user WHERE email = ? AND password = ? AND role != 'client'";
            ps = cn.prepareStatement(sql);
            ps.setString(1, email);
            ps.setString(2, hashed_password);

            rs = ps.executeQuery();

            if (rs.next()) {
                return new User(
                        rs.getString("email"),
                        rs.getString("firstname"),
                        rs.getString("lastname"),
                        rs.getString("role")
                );
            } else {
                return null;
            }

        } catch (SQLException e) {
            e.printStackTrace();
        } catch (ClassNotFoundException e) {
            e.printStackTrace();
        } finally {
            try {
                cn.close();
                ps.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
        return null;
    }
}

