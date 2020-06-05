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

            String sql = "select user.id, email, firstname, lastname, role, count(sale.id) as orders from user " +
                    "left join sale on user.id = sale.user_client where user.role = 'Client' group by user.id";

            rs = st.executeQuery(sql);

            while (rs.next()) {
                javafx.User userN = new javafx.User(
                        rs.getString("id"),
                        rs.getString("email"),
                        rs.getString("firstname"),
                        rs.getString("lastname"),
                        rs.getString("role"),
                        rs.getString("orders")
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

    public ArrayList<javafx.Promotion> getUserPromotionsDB(String user_id) {
        ArrayList<javafx.Promotion> promoList = new ArrayList<javafx.Promotion>();

        try {
            Class.forName("com.mysql.cj.jdbc.Driver");

            cn = DriverManager.getConnection(url, user, db_password);


            String sql = "SELECT id, user_id, promo_type, promotion.value FROM promotion WHERE user_id = ?";
            ps = cn.prepareStatement(sql);
            ps.setInt(1, Integer.parseInt(user_id));

            rs = ps.executeQuery();

            while (rs.next()) {
                javafx.Promotion promotionN = new javafx.Promotion(
                        rs.getString("id"),
                        rs.getString("user_id"),
                        rs.getString("promo_type"),
                        rs.getString("value")
                );
                promoList.add(promotionN);
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
        return promoList;
    }

    public User Login(String email, String password) {
        String hashed_password = DigestUtils.sha256Hex(password);

        try {
            Class.forName("com.mysql.cj.jdbc.Driver");

            cn = DriverManager.getConnection(url, user, db_password);

            String sql = "SELECT id, email,firstname,lastname,role FROM user WHERE email = ? AND password = ? AND role != 'client'";
            ps = cn.prepareStatement(sql);
            ps.setString(1, email);
            ps.setString(2, hashed_password);

            rs = ps.executeQuery();

            if (rs.next()) {
                return new User(
                        rs.getString("id"),
                        rs.getString("email"),
                        rs.getString("firstname"),
                        rs.getString("lastname"),
                        rs.getString("role"),
                        null
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

    public void removePromotion(int promo_id) {
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");

            cn = DriverManager.getConnection(url, user, db_password);

            String sql = "DELETE FROM promotion WHERE id = ?;";
            ps = cn.prepareStatement(sql);
            ps.setInt(1, promo_id);

            ps.execute();

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
    }
}

